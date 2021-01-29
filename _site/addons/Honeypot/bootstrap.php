<?php
/**
 * Cockpit honeypot addon
 *
 * @author  Raruto
 * @package cockpit-blog
 * @license MIT
 */

/**
* Helper function to generate unique honeypot names
*/
$app->module('honeypot')->extend([

    'getHoneypotFieldName' => function($name) {
        return "hp-$name";
    },

]);

/**
 * Append "honeypot" field to cockpit forms api
 *
 * @link https://github.com/Raruto/cockpit-extended-forms
 * @see { cockpit( 'forms:open' , 'form-name' ) }
 */
if ($app->module('extendedforms')) {

    $app->on('forms.open.after', function($name, &$options) {
        $frm = $this->module('forms')->form($name);
        if (!empty($frm['honeypot'])) {
          $this->renderView('honeypot:views/honeypot.php', ['name' => $name]);
        }
    });

} else {

    /**
     * Save default form "open" function for later override.
     *
     * @see { cockpit/modules/forms/bootstrap.php }
     */
    $OPEN = $app->module('forms')->open;

    $app->module('forms')->extend([
      'open' => function($name, $options = []) use($OPEN) {
        $frm = $this->form($name);
        $OPEN($name, $options);
        if(!empty($frm['honeypot'])) {
          $this->app->renderView('honeypot:views/honeypot.php');
        }
      },
    ]);

}

/**
 * Custom form validation hook
 *
 * @param  string $form    submitted form name
 * @param  array  $data    submitted form entry
 * @param  array  $frm     form collection
 * @param  array  $options form options
 *
 * @return void
 *
 * @see { cockpit/modules/forms/bootstrap.php }
 */
$app->on('forms.submit.before', function($form, &$data, $frm, &$options) {

  // check for [ "honeypot" => true ] in form collection
  if (empty( $frm['honeypot']))  return;

  $hp_name = $this->module('honeypot')->getHoneypotFieldName($form);

  // validate "honeypot" field in submitted entry
  if (!empty($data[$hp_name])) {
    $this->stop(200);
  }
  // exclude "honeypot" field from saved entries
  unset($data[$hp_name]);

});

/**
 * Add honeypot button to form settings
 *
 * @return void
 *
 * @see { cockpit/modules/forms/views/form.php }
 */
$app->on('forms.settings.aside', function() {
    $this->app->renderView('honeypot:views/settings-field.php');
});
