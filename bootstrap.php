<?php

if (!defined('ABSPATH')) {
  exit;
}

/** Cockpit enviroment **/
define('COCKPIT_FRONTEND', true);

define('COCKPIT_THEME', ABSPATH . '/_site/_theme');

/**
 * Lime App (frontend)
 *
 * use "LimeExtra\App"        for take advantage of inbuilt "Lexy Template Language" (eg. @extend, @render, @trigger, ...)
 * use "Lime\App"             if you are willing to use "plain" php files (ie. without a templating language)
 * use "LimeExtra\Controller" if you intend to develop a class based router (make use of {{ $app->loadModules }})
 * use {{ $app = cockpit() }} if you prefer to share the same addons and configs (NB. $cockpit == cockpit() )
 *
 * @see { cockpit/bootstrap.php | cockpit/lib/Lime/App.php } for a comprehensive list of available options
 */
$app = new LimeExtra\App(
  [
    'debug'            => $cockpit['debug'],
    'debug.info'       => $cockpit['debug'] && defined('DEBUG_DISPLAY') && DEBUG_DISPLAY,

    'app.name'         => 'Cockpit Blog',
    'app.short_name'   => 'Cockpit',
    'app.description'  => 'Just a simple Cockpit Blog',

    'meta.robots'      => 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1',
    'meta.generator'   => $cockpit['debug'] ? 'cockpit-next v' . \json_decode($cockpit->helper('fs')->read('#root:package.json'), true)['version'] : '',

    'matomo.url'       => cockpit()->getSiteUrl(true) . '/analytics/matomo/',
    'matomo.id'        => '1',

    'pagination.limit' => '5',

    'session.name'     => $cockpit['session.name'],
    'sec-key'          => $cockpit['sec-key'],

    // 'base_url'      => implode('/', \array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)),
    // 'base_route'    => implode('/', \array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)),
    // 'base_host'     => $_SERVER['SERVER_NAME'] ?? \php_uname('n'),
    // 'base_port'     => $_SERVER['SERVER_PORT'] ?? 80,

    // 'site_url'      => null
    // 'route'         => $_SERVER['PATH_INFO'] ?? '/',
    // 'docs_root'     => str_replace(DIRECTORY_SEPARATOR, '/', isset($_SERVER['DOCUMENT_ROOT']) ? \realpath($_SERVER['DOCUMENT_ROOT']) : \dirname($_SERVER['SCRIPT_FILENAME'])),

    // 'i18n'          => 'en',
    // 'charset'       => 'UTF-8',

    // 'database'      => ['server' => 'mongolite://'.(COCKPIT_STORAGE_FOLDER.'/data'), 'options' => ['db' => 'cockpitdb'], 'driverOptions' => [] ],
    // 'memory'        => ['server' => 'redislite://'.(COCKPIT_STORAGE_FOLDER.'/data/cockpit.memory.sqlite'), 'options' => [] ],

    'paths'            => array_replace_recursive($cockpit['paths'],
    [
      // '#root'     => COCKPIT_DIR,
      // '#storage'  => COCKPIT_STORAGE_FOLDER,
      // '#pstorage' => COCKPIT_PUBLIC_STORAGE_FOLDER,
      // '#data'     => COCKPIT_STORAGE_FOLDER.'/data',
      // '#cache'    => COCKPIT_STORAGE_FOLDER.'/cache',
      // '#tmp'      => COCKPIT_STORAGE_FOLDER.'/tmp',
      // '#thumbs'   => COCKPIT_PUBLIC_STORAGE_FOLDER.'/thumbs',
      // '#uploads'  => COCKPIT_PUBLIC_STORAGE_FOLDER.'/uploads',
      // '#modules'  => COCKPIT_DIR.'/modules',
      // '#addons'   => COCKPIT_ENV_ROOT.'/addons',
      // '#config'   => COCKPIT_CONFIG_DIR,
      // 'assets'    => COCKPIT_DIR.'/assets',
      // 'site'      => COCKPIT_SITE_DIR

      'theme'          => COCKPIT_THEME,
      'views'          => COCKPIT_THEME . '/views',
      'blocks'         => COCKPIT_THEME . '/views/blocks',
      'layouts'        => COCKPIT_THEME . '/views/layouts',
      'partials'       => COCKPIT_THEME . '/views/partials',
    ]),

    // 'autoload'      => new \ArrayObject([]),
    // 'helpers'       => [
    //   'acl'       => 'LimeExtra\\Helper\\SimpleAcl',
    //   'assets'    => 'LimeExtra\\Helper\\Assets',
    //   'fs'        => 'LimeExtra\\Helper\\Filesystem',
    //   'image'     => 'LimeExtra\\Helper\\Image',
    //   'i18n'      => 'LimeExtra\\Helper\\I18n',
    //   'utils'     => 'LimeExtra\\Helper\\Utils',
    //   'coockie'   => 'LimeExtra\\Helper\\Cookie',
    //   'yaml'      => 'LimeExtra\\Helper\\YAML',
    // ]

    // 'debug'         => preg_match('/(localhost|::1|\.local)$/', @$_SERVER['SERVER_NAME']),

    // 'sec-key'       => 'xxxxx-SiteSecKeyPleaseChangeMe-xxxxx',
    // 'session.name'  => md5(str_replace(DIRECTORY_SEPARATOR, '/', __DIR__)),
]);

/**
 * Parent HTML template
 *
 * same as (Lime):       {{ $app->render("xxx.php use with layouts:base.php") }}
 * same as (LimeExtra):  {{ $app->view("xxx.php use with layouts:base.php") }}
 * same as (lexy):       {{ @extend('layouts:base.php') }}
 *
 * @see { Lime/App | LimeExtra/App | cockpit/lib/Lexy.php }
 */
// $app->layout = 'layouts:base.php';

/**
 *  PATHS
 *
 * use {{ $app->path($key, $path); }} to write new value
 * use {{ $app->path($key); }}        to read single value
 * use {{ $app->paths($namespace); }} to retrieve grouped paths (eg. cockpit()->paths('#cli'))
 * use {{ $app->paths(); }}           to retrieve all saved values
 *
 * @see { Lime/App | cockpit/bootstrap.php }
 */
foreach ($app['paths'] as $key => $path) {
    $app->path($key, $path);
}

/**
 *  frontend specific addons
 */
$app->loadModules($cockpit['loadmodules'] ?? []);
// $app->loadModules([$app->path('theme:modules')], true, 'theme');
// $app->loadModules([$app->path('theme:addons')], true, 'theme');

include(COCKPIT_THEME.'/bootstrap.php');
