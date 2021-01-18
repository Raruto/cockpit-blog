<?php
/**
 * Cockpit honeypot addon
 *
 * @author  Raruto
 * @package cockpit-blog
 * @license MIT
 */

/**
 * Save default form "open" function for later override.
 *
 * @see { cockpit/modules/forms/bootstrap.php }
 */
$OPEN = $app->module('forms')->open;

/**
 * Append "honeypot" field to cockpit forms api
 *
 * @see { cockpit( 'forms:open' , 'form-name' ) }
 */
$app->module('forms')->extend([
  'open' => function($name, $options = []) use($OPEN) {
    $frm = $this->form($name);
    $OPEN($name, $options);
    if( !empty( $frm['honeypot'] ) ) {
      $this->app->renderView( 'honeypot:views/honeypot.php' );
    }
  },
]);

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
  // check [ "honeypot" => true ] in form collection
  if ( !empty( $frm['honeypot'] ) ) {
    // validate "honeypot" field in submitted entry
    if ( !empty( $data['cfw-name'] ) ) {
      $this->stop(200);
    }
    // exclude "honeypot" field from saved entries
    unset( $data['cfw-name'] );
  }
});

$app->on('forms.settings.aside', function() use ($app) {
	echo $app->view( 'honeypot:views/settings-field.php' );
});
