<?php
/**
 * Simple blog implementation with a router
 *
 * @author  Raruto
 * @package cockpit-blog
 * @license MIT
 */

/**
 * Define some CONSTANTS and include COCKPIT library
 */

/** App start time **/
define('START_TIME', microtime(true));

/** Cockpit enviroment **/
define('COCKPIT_FRONTEND', true);

/** Cockpit folder name **/
define('COCKPIT', 'admin');

/** Theme folder name **/
define('THEME', '_site/theme');

// set default timezone
date_default_timezone_set('UTC');

// handle php webserver (dev-only) [ php -S localhost:8080 index.php ]
if (PHP_SAPI == 'cli-server' && false === include_once('.ht.router.php')) {
    return false;
}

// cockpit library
if (file_exists(COCKPIT.'/bootstrap.php')) {
  include(COCKPIT.'/bootstrap.php');
} else {
  exit('Cockpit not installed');
}

// bootstrap theme
require(THEME.'/bootstrap.php');

# Set default route
if (COCKPIT_FRONTEND && !defined('COCKPIT_SITE_ROUTE')) {
    $route = preg_replace('#'.preg_quote($app['base_route'], '#').'#', '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), 1);
    define('COCKPIT_SITE_ROUTE', $route == '' ? '/' : $route);
}

/**
 * Start Lime App
 *
 * use {{ $app->run('/*'); }} if you wish to do things before dispatching yourself the {{ $app->render_route($route); }}
 *
 * @see { Lime/App }
 */
$app->set('route', COCKPIT_SITE_ROUTE)->trigger('site.init')->run();
