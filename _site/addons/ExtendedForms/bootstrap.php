<?php
/**
 * Cockpit extended forms addon
 *
 * @author  Raruto
 * @package cockpit-blog
 * @license MIT
 *
 * @see https://github.com/agentejo/cockpit/pull/1411
 * @see https://github.com/agentejo/cockpit/pull/1399
 * @see https://github.com/agentejo/cockpit/pull/1400
 */

/**
 * Autoload helpers by Lime\App::loadModules()
 */
$this->helpers['extendedforms'] = 'ExtendedForms\\Helper\\Utils';

/**
* You can also save default "Forms" prototypes for later override.
*
* @see { cockpit/modules/forms/bootstrap.php }
*/
$FORMS_OPEN   = cockpit()->module('forms')->open;
$FORMS_SUBMIT = cockpit()->module('forms')->submit;

/**
 * Extend core "Forms" module beahvior.
 */
cockpit()->module('forms')->extend([

     /**
      * Override core "Forms::open" beahvior.
      *
      * @see https://github.com/agentejo/cockpit/pull/1400
      */
    'open' => function($name, $options = []) use ($FORMS_OPEN) {

        $this->app->trigger("forms.open.before", [$name, &$options]);

        $options = array_merge([
            'id'          => uniqid('form'),
            'class'       => '',
            'action'      => $this->app->routeUrl('/api/forms/submit/'.$name),
            'method'      => 'post',
            'enctype'     => 'multipart/form-data',
            'csrf'        => $this->app->hash($name),
            'mailsubject' => false,
            'include_js'  => true
        ], $options);

        // $FORMS_OPEN($name, $options);

        $this->app->renderView('extendedforms:views/api/form.php', compact('name', 'options'));

        $this->app->trigger("forms.open.after", [$name, &$options]);

    },

    /**
     * Add custom "Forms::close" function.
     *
     * @see https://github.com/agentejo/cockpit/pull/1400
     */
    'close' => function($name = null, $options = []) {

        $this->app->trigger("forms.close.before", [$name, &$options]);
        echo '</form>';
        $this->app->trigger("forms.close.after", [$name, &$options]);

    },

    /**
     * Override core "Forms::submit" beahvior.
     *
     * @see https://github.com/agentejo/cockpit/pull/1399
     */
    'submit' => function($form, $data, $options = []) use ($FORMS_SUBMIT) {

        $frm = $this->form($form);

        // Invalid form name
        if (!$frm) {
            return false;
        }

        // Load custom form validator
        if ($this->app->path("#config:forms/{$form}.php") && false === include($this->app->path("#config:forms/{$form}.php"))) {
            return false;
        }

        // Filter submitted data
        $this->app->trigger('forms.submit.before', [$form, &$data, $frm, &$options]);

        // Send email
        if (isset($frm['email_forward']) && $frm['email_forward']) {

            $emails          = array_map('trim', explode(',', $frm['email_forward']));
            $filtered_emails = [];

            // Validate each email address individually, push if valid
            foreach ($emails as $to) {
                if ($this->app->helper('utils')->isEmail($to)){
                    $filtered_emails[] = $to;
                }
            }

            if (count($filtered_emails)) {

                $frm['email_forward'] = implode(',', $filtered_emails);

                // Load custom email template
                if ($template = $this->app->path("#config:forms/emails/{$form}.php")) {
                    $body = $this->app->view($template, ['data' => $data, 'frm' => $frm]);
                }

                // Filter email content
                $this->app->trigger('forms.submit.email', [$form, &$data, $frm, &$body, &$options]);

                // Fallback to default email template
                if (empty($body)) {
                    $body = $this->app->view("extendedforms:views/api/email.php", ['data' => $data, 'frm' => $frm]);
                }

                $formname = isset($frm['label']) && trim($frm['label']) ? $frm['label'] : $form;
                $to       = $frm['email_forward'];
                $subject  = $options['subject'] ?? $this->app->helper('i18n')->getstr("New form data for: %s", [$formname]);

                // success = true
                try {
                    $response = $this->app->mailer->mail($to, $subject, $body, $options);
                } catch (\Exception $e) {
                    $response = $e->getMessage();
                }
            }
        }

        // Push entry to database
        if (isset($frm['save_entry']) && $frm['save_entry']) {
            $entry = ['data' => $data];
            $this->save($form, $entry);
        }

        // Generate response array
        $response = (isset($response) && $response !== true) ? ['error' => $response, 'data' => $data] : $data;

        // Filter submission response
        $this->app->trigger('forms.submit.after', [$form, &$data, $frm, &$response]);

        return $response;
    }

]);

/**
* Extend Lexy Parser (templating engine)
*
* @link https://cpmultiplane.rlj.me/en/docs/lexy with available language structures
* @see { cockpit/lib/Lexy.php | cockpit/bootsrap.php }
*/
cockpit()->renderer->extend(function($content) {

    $replace = [
        'form'    => '<?php cockpit()->module("forms")->open(expr); ?>', // @form(expr)
        'endform' => '<?php cockpit()->module("forms")->close(expr); ?>', // @endform(expr)
    ];

    $content = preg_replace_callback('/\B@(\w+)([ \t]*)(\( ( (?>[^()]+) | (?3) )* \))?/x', function($match) use($replace) {
        if (trim($match[1]) && isset($replace[$match[1]])) {
            return str_replace('(expr)', isset($match[3]) ? $match[3] : '()', $replace[$match[1]]);
        }
        return $match[0];
    }, $content);

    return $content;

});

/**
 * Check and populate forms $data['files'] entry
 *
 * @return array $folder
 */
cockpit()->on('forms.submit.before', function($form, &$data, $frm, &$options) {

    $forms = $this->helper('extendedforms');
    $files = $forms->get_uploaded_files();

    if (!empty($files)) {

        $files = $this->module('cockpit')->uploadAssets('files', ['folder' => $forms->get_forms_uploads_folder()]);

        // save entries as filename
        $data['files'] = $files['uploaded'];

        // save entries as filepath
        // $data['files'] = [];
        // $ASSETS_URL    = rtrim($app->filestorage->getUrl('assets://'), '/');
        //
        // foreach($files['assets'] as $file) {
        //   $data['files'][] = $ASSETS_URL.$file['path'];
        // }

    }

});
