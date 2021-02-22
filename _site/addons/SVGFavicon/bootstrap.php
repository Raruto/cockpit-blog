<?php
/**
 * Cockpit app favicon addon
 *
 * @author  Raruto
 * @package cockpit-blog
 * @license MIT
 */

/**
 * Change image favicon, login and dashboard
 *
 * @link https://discourse.getcockpit.com/t/change-image-favicon-login-and-dashboard/1343
 */
if (COCKPIT_ADMIN && !COCKPIT_API_REQUEST) {

    $app->on(['app.layout.header', 'app.login.header'], function() {

      if ($this['debug']) {
          ?><link rel="icon" type="svg" href="<?= $this->pathToUrl('svgfavicon:views/favicon.svg') ?>" app-icon="true"><?php
      }
    });

}

// Favicon
$app->bind('/favicon.svg', function() {
    if($this['debug']) {
        return $this->view('svgfavicon:views/favicon.svg');
    }
    return $this->view('#pstorage:app/favicon.svg');
});
