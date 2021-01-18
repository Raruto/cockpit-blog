<?php
/**
 * TODO: Contact form validation.
 *
 * use "contact.php" for a form named "contact"
 *
 * @link https://github.com/raffaelj/cockpit-scripts/blob/master/form-validation/contact.php
 * @link https://github.com/COCOPi/cockpit-docs/blob/master/modules/forms.md
 *
 * @see { _site/forms/contact.form.php }
 */

// check required fields
if ( empty( $data['name'] ) || empty( $data['email'] ) || empty( $data['message'] ) || empty( $data['privacy'] ) ) {
  $this->stop( [ 'error' => 'Invalid form' ], 412 );
}

// validate response
return true;
