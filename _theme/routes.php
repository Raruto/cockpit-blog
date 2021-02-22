<?php
/**
 * Render ROUTES
 *
 * use {{ $app->viewvars['custom_var'] }} for having {{ $custom_var }} variable globally available in template files
 * use {{ $content_for_layout }} variable in "layouts:base.php" for echoing content coming from partials files
 * use {{ return false; }} inside calback functions for returning a 404 response
 *
 * @see { Lime/App | LimeExtra/App | Lime/Request | Lime/Response } for available helper functions.
 */

$app->on('site.init', function() use (&$app) {

    // Rest API
    $app->bind('/api/*', function($params) use (&$app) {
      // TODO: how to proxy admin/index.php? (eg. htaccess)
      // 302 redirect to admin API.
      return $app->reroute(COCKPIT .'/api/' . rtrim($params[':splat'][0], '/') . (empty($_SERVER['QUERY_STRING']) ? '' : '?'. $_SERVER['QUERY_STRING']));
    });

    // Everything else [404]
    $app->bind('/*', function($params) use (&$app) {
      return false;
    });

}, 0);
