<?php
/**
 * Cockpit live preview addon
 *
 * @author  Raruto
 * @package cockpit-blog
 * @license MIT
 */

if (COCKPIT_ADMIN && !COCKPIT_API_REQUEST) {
  $this->on('admin.init', function() {
    // link to website in system menu
    $this->on('cockpit.menu.system', function() {
      $this->renderView(__DIR__ . '/views/system.menu.php');
    });
  });
}

/**
 * TODO: live preview support
 */
// if (COCKPIT_ADMIN && !COCKPIT_API_REQUEST) {
//   // define('COCKPIT_LIVE_PREVIEW_TOKEN', \uniqid(\bin2hex(\random_bytes(16))));
// 	define('COCKPIT_LIVE_PREVIEW_TOKEN', 'hello');
//
//   foreach (['posts', 'pages'] as $col) {
//     $this->module('collections')->updateCollection($col, [
//       'contentpreview' => [
//         'enabled'  => true,
//         'url' => $this['site_url'] . $this['base_route'] . '/livePreview?token=' . COCKPIT_LIVE_PREVIEW_TOKEN,
//       ]
//     ]);
//   }
//
//   $this->bind('/getPreview', function($params) {
//     $data = $this->app->request->request;
//     if ($data['event'] == 'cockpit:collections.preview') {
//       $collection            = $data['collection'] == 'posts' ? 'post' : 'page';
//       $this->viewvars['page'] = $page = $data['entry'];
//       return $this->app->view( COCKPIT_SITE_DIR . "/views/{$collection}.php with " . COCKPIT_SITE_DIR . "/views/layouts/empty.php");
//     }
//     return false;
//   }, $this->req_is('ajax'));
//
//   $this->bind('/livePreview', function($params) {
//     if ($this->param('token') == COCKPIT_LIVE_PREVIEW_TOKEN ) {
//       return $this->view( __DIR__ .  "/views/live-preview.php with " . COCKPIT_SITE_DIR . "/views/layouts/base.php");
//     }
//     return false;
//   });
// }
