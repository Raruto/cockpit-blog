<?php

if (!defined('ABSPATH')) {
  exit;
}

/** Cockpit enviroment **/
define('COCKPIT_FRONTEND', true);

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

      // 'theme'          => ABSPATH . '/_site/theme',
      'views'          => ABSPATH . '/_site/_views',
      'blocks'         => ABSPATH . '/_site/_views/blocks',
      'layouts'        => ABSPATH . '/_site/_views/layouts',
      'partials'       => ABSPATH . '/_site/_views/partials',
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


/**
 * Custom template HOOKS
 *
 * use {{ @trigger('custom.hook.name') }} inside template files for firing your custom event
 *
 * @see { layouts:base.php }
 */

// After opening <body> tag
// $app->on('site.header.scripts', function() { });

// Beside {{ $content_for_layout }} variable
$app->on('site.contentbefore',  function() { echo '<main>'; });
$app->on('site.contentafter',   function() { echo '</main>'; });

// Before closing </body> tag
// $app->on('site.footer', function() { });

// After opening <body> tag
$app->on('site.header.scripts', function() { cockpit()->module('matomo')->render(); });

$app->on('sitemap.head',        function() { $this->renderView('partials:sitemap-head.php'); });
$app->on('sitemap.footer',      function() { $this->renderView('partials:sitemap-footer.php'); });

/**
 * Lime HOOKS (frontend)
 *
 * @see { LimeExtra/App | Lime/App }
 */

$app->on('site.init', function() use (&$app) {

    // Fired at the beginning of the {{ $app->view() }} rendering function
    $app->on('app.render.view', function(&$template, &$slots) use (&$app) {
        // make $page variable globally available in template files
        $page = $slots['page'] ?? [];
        if( !empty($page) ) {
            $this->viewvars['page'] = $page = array_replace_recursive([
                'title'          => '',
                'description'    => $app['app.description'] ?? '',
                'meta.robots'    => $app['meta.robots'] ?? '',
            ], $page);
        }
    });

    /**
     * Module HOOKS (backend)
     *
     * @see { cockpit/modules/Collections/bootstrap.php }
     */

    // Fired at the beginning of the {{ cockpit('collections')->find($collection, $options = []) }} function
    cockpit()->on(
        [
            'collections.find.before.posts',
            'collections.find.before.pages'
        ],
        function($name, &$options) {
            // set default "filter" to published
            if (!isset($options['filter'])) {
                $options['filter'] = [ 'published' => true ];
            } else if( !isset($options['filter']['published']) ) {
                $options['filter']['published'] = true;
            }
            // set default "sort" order to created
            if (!isset($options['sort'])) {
                $options['sort'] = [ '_created' => -1 ];
            } else if( !isset($options['sort']['_created']) ) {
                $options['sort']['_created'] = -1;
            }
        }
    );

    // Fired at the end of the {{ cockpit('collections')->find($collection, $options = []) }} function
    cockpit()->on('collections.find.after', function($name, &$entries) use ($app) {
        foreach ($entries as $k => $entry) {
            if (isset($entry['content'])) {
                // render lexy code @snippets
                $entries[$k]['content'] = $app->renderer->execute($entries[$k]['content'], $app->viewvars);
            }
        }
    });

});

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
