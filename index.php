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

// set default timezone
date_default_timezone_set('UTC');

// handle php webserver (dev-only) [ php -S localhost:8080 index.php ]
if ( PHP_SAPI == 'cli-server' ) {
  $path  = __DIR__ . parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );
  $index = rtrim( $path, '/') . '/index.php';
  /* "dot" routes (see: https://bugs.php.net/bug.php?id=61286) */
  $_SERVER['PATH_INFO'] = $_SERVER['REQUEST_URI'];
  /* static files (eg. css/app.css) */
  if ( is_file( $path ) ) {
    return false;
  }
  /* index files (eg. install/index.php) */
  if ( is_file( $index ) && $_SERVER['REQUEST_URI'] != '/' ) {
    include_once( $index);
    exit;
  }
  /* admin routes (eg. admin/api/get/collection/posts) */
  if ( strpos( rtrim( $_SERVER['REQUEST_URI'], '/') . '/', '/'. COCKPIT . '/' ) === 0) {
    str_replace( "/". COCKPIT, '', $_SERVER['REQUEST_URI'] );
    str_replace( "/". COCKPIT, '', $_SERVER['PATH_INFO'] );
    include_once( COCKPIT . '/index.php');
    exit;
  }
}

// admin router
// include_once( COCKPIT . '/index.php');

// cockpit library
include_once( COCKPIT . '/bootstrap.php');

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
    'debug'            => preg_match('/(localhost|::1|\.local)$/', @$_SERVER['SERVER_NAME']),
    'debug.info'       => defined('DEBUG_DISPLAY') && DEBUG_DISPLAY,

    'app.name'         => 'Cockpit Blog',
    'app.short_name'   => 'Cockpit',
    'app.description'  => 'Just a simple Cockpit Blog',

    'meta.robots'      => 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1',
    'meta.generator'   => 'cockpit-next v' . \json_decode($cockpit->helper('fs')->read('#root:package.json'), true)['version'],

    'matomo.url'       => $cockpit->getSiteUrl(true) . '/analytics/matomo/',
    'matomo.id'        => '1',

    'pagination.limit' => '5',

    // 'session.name'  => md5(str_replace(DIRECTORY_SEPARATOR, '/', __DIR__)),

    // 'base_url'      => implode('/', \array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)),
    // 'base_route'    => implode('/', \array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)),
    // 'base_host'     => $_SERVER['SERVER_NAME'] ?? \php_uname('n'),
    // 'base_port'     => $_SERVER['SERVER_PORT'] ?? 80,

    // 'site_url'      => null
    // 'route'         => $_SERVER['PATH_INFO'] ?? '/',
    // 'docs_root'     => str_replace(DIRECTORY_SEPARATOR, '/', isset($_SERVER['DOCUMENT_ROOT']) ? \realpath($_SERVER['DOCUMENT_ROOT']) : \dirname($_SERVER['SCRIPT_FILENAME'])),

    // 'sec-key'       => 'xxxxx-SiteSecKeyPleaseChangeMe-xxxxx',

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
 * Register PATHS
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
 * Set CACHE folder
 *
 * @see { Lime/App | Lime/Helper/Cache | cockpit/lib/Lexy.php | cockpit/bootstrap.php }
 */
$CACHE_DIR = $app->path('#cache:'); // eg. "_site/cache"

$app('cache')->setCachePath($CACHE_DIR);  // *.cache.php
$app->renderer->setCachePath($CACHE_DIR); // *.lexy.php

// empty cache folder if debug enabled
if($app['debug']) {
  $cached = new \FilesystemIterator($CACHE_DIR, FilesystemIterator::SKIP_DOTS);
  foreach ( $cached as $item) {
    // skip hidden files and directories
    if ($item->getFilename()[0] !== '.') {
      $app('fs')->delete($item->getRealPath());
    }
  }
}

/**
 * Extend Lexy Parser (templating engine)
 *
 * @link https://cpmultiplane.rlj.me/en/docs/lexy with available language structures
 * @see { cockpit/lib/Lexy.php | cockpit/bootsrap.php }
 */
$app->renderer->extend(function($content) {
    $replace = [
      'dump'     => '<?php echo highlight_str(expr); ?>',                       // @dump(expr)
      'json'     => '<?php echo json_encode(expr); ?>',                         // @json(expr)
      'form'     => '<?php cockpit()->module("forms")->open(expr); ?>'          // @form(expr)
    ];

    $content = preg_replace('/(\s*)@(endform)(\s*)/', '$1</form>$3', $content); // @endform

    $content = preg_replace_callback('/\B@(\w+)([ \t]*)(\( ( (?>[^()]+) | (?3) )* \))?/x', function($match) use($replace) {
      if (isset($match[3]) && trim($match[1]) && isset($replace[$match[1]])) {
        return str_replace('(expr)', $match[3], $replace[$match[1]]);
      }
      return $match[0];
    }, $content);

    return $content;
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

// Home page
$app->bind('/', function($params) use (&$app) {
  return $this->render_route('/blog/*');
});

// Search page
$app->bind('/search', function($params) use (&$app) {
  return $app->view('views:form/search.php');
});

// Contact page
$app->bind('/contact', function($params) use (&$app) {
  return $app->view('views:form/contact.php');
});

// Test page
$app->bind('/test', function() {
  $this->response->mime = 'json';
  return json_encode(['status' => 200, 'message' => $this('i18n')->get('It works!')]);
});

// Login page
$app->bind('/login', function() use (&$app) {
  return $app->reroute(COCKPIT);
});

// Sitemap [index]
$app->bind('/sitemap.xml', function() use (&$app) {
  return $app->view('views:sitemap.xml');
});

// Sitemap [xsl]
$app->bind('/sitemap.xsl', function() use (&$app) {
  return $app->view('views:sitemap.xsl');
});

// Sitemap [posts]
$app->bind('/posts-sitemap.xml', function() use (&$app) {
  return $app->view('views:posts-sitemap.xml');
});

// Sitemap [pages]
$app->bind('/pages-sitemap.xml', function() use (&$app) {
  return $app->view('views:pages-sitemap.xml');
});

// Feed [xml]
$app->bind('/feed/feed.xml', function() use (&$app) {
  return $app->view('views:/feed/feed.xml');
});

// Feed [json]
$app->bind('/feed/feed.json', function() use (&$app) {
  return $app->view('views:/feed/feed.json');
});

// Robots
$app->bind('/robots.txt', function() use (&$app) {
  return $app->view('views:robots.txt');
}, '/' === $app['base_url'] /* display robots.txt only if we are in top-level directory of the host. */ );

// Manifest
$app->bind('/manifest.json', function() use (&$app) {
  return $app->view('views:manifest.json');
});

// Service Worker [PWA]
$app->bind('/sw.js', function() use (&$app) {
  return $app->view('views:sw.js');
});

// Favicon
$app->bind('/favicon.svg', function() use (&$app) {
  return $app->view('views:favicon.svg');
});

// Single page
$app->bind('/:slug', function($params) use (&$app) {
  // home page redirect
  if(empty($params['slug'])) return $app->reroute('/');
  // search pages by slug
  $page = cockpit('collections')->findOne('pages', [ 'slug' => $params['slug'] ]);
  if(!empty($page)) return $app->view('views:page.php', compact('page'));
  // fallback to blog pagination (:slug --> :splat)
  if(is_numeric($params['slug'])) return $app->render_route('/blog/*', [ ':splat' => [ substr($app['route'], 1) ] ] );
});

// Single post
$app->bind('/article/:slug', function($params) use (&$app) {
  // home page redirect
  if(empty($params['slug'])) return $app->reroute('/');
  // search posts by slug
  $post = cockpit('collections')->findOne('posts', [ 'slug' => $params['slug'] ]);
  if(!empty($post)) {
    return $app->view('views:post.php', compact('post'));
  }
});

// Posts archive
$app->bind('/blog/*', function($params) use (&$app) {
  // set default pagenum ('1')
  if(empty($params[':splat'][0])) $params[':splat'][0] = '1';
  // pagination route: "/blog/:pagenum"
  $parts     = explode('/',$params[':splat'][0], 2);
  $page      = [
    'base_route' => rtrim(str_replace($params[':splat'][0], '', $app['route']), '/') . '/' . $parts[0],
    'collection' => 'posts',
    'query'      => [
      'filter' => [ 'published' => true /*, 'tags' => [ '$in' => [ $parts[0] ] ]*/ ],
      'sort'   => [ '_created' => -1 ],
      'skip'   => intval($parts[1] ?? 1) - 1,
      'limit'  => intval($app['pagination.limit'] ?? 5)
    ]
  ];
  return $app->view('views:archive.php', compact('page'));
});

// Tag archive
$app->bind('/tag/*', function($params) use (&$app) {
  // home page redirect
  if(empty($params[':splat'][0])) return $app->reroute('/');
  // pagination route: "/tag/:id/:pagenum"
  $parts     = explode('/',$params[':splat'][0], 2);
  $page      = [
    'title'      => $parts[0],
    'base_route' => rtrim(str_replace($params[':splat'][0], '', $app['route']), '/') . '/' . $parts[0],
    'collection' => 'posts',
    'query'      => [
      'filter' => [ 'published' => true, 'tags' => [ '$in' => [ $parts[0] ] ] ],
      'sort'   => [ '_created' => -1 ],
      'skip'   => intval($parts[1] ?? 1) - 1,
      'limit'  => intval($app['pagination.limit'] ?? 5)
    ]
  ];
  return $app->view('views:archive.php', compact('page'));
});

// Posts Feed
$app->bind('/feed', function() use (&$app) {
  $this->response->mime = 'xml';
  return $app->render_route('/feed/feed.xml');
});

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

/**
 * Custom template HOOKS
 *
 * use {{ @trigger('custom.hook.name') }} inside template files for firing your custom event
 *
 * @see { layouts:base.php }
 */

// After opening <body> tag
$app->on('site.header.scripts', function() {
  // inject matomo tracking code
  if(!empty($this['matomo.url']) && !empty($this['matomo.id'])) echo "<script>{$this->view('partials:matomo.js')}</script>";
});

// Beside {{ $content_for_layout }} variable
$app->on('site.contentbefore', function() { echo '<main>'; });
$app->on('site.contentafter', function() { echo '</main>'; });

// Before closing </body> tag
$app->on('site.footer', function() {
  // print some debug info
  if($this['debug.info']) $this->renderView('partials:debug.php');
  // inject service worker code
  echo "<script>{$this->view('partials:sw-register.js')}</script>";
});

/**
 * Lime HOOKS (frontend)
 *
 * @see { LimeExtra/App | Lime/App }
 */

// Fired at the beginning of the {{ $app->view() }} rendering function
$app->on('app.render.view', function(&$template, &$slots) use (&$app) {
  // make $page variable globally available in template files
  $page = $slots['page'] ?? $slots['post'] ?? [];
  if( !empty($page) ) {
    $this->viewvars['page'] = $page = array_replace_recursive([
      'title'          => '',
      'description'    => $app['app.description'] ?? '',
      'meta.robots'    => $app['meta.robots'] ?? '',
    ], $page);
  }
});

// Fired at the beginning of the {{ $app->run() }} routine
$app->on('before', function() {
  // skip check if route is already registered (eg. "/login")
  if (isset($this->routes[$this->registry['route']])) return;

  // fallback for un-registered routes when url ends with "/"
  $path = trim($this->registry['route'], '/');

  /* eg. "/login/" --> "/login" */
  if (isset($this->routes["/$path"]))  return $this->registry['route'] = "/$path";

  /* eg. "/article/:slug/" --> "/article/:slug" */
  foreach ($this->routes as $route => $callback) {
    /* skip if regex (e.g. #\.html$#) */
    if (\substr($route,0,1)=='#' && \substr($route,-1)=='#') continue;
    /* skip if splat (e.g. /admin/*) */
    if (\strpos($route, '*') !== false) continue;
    /* check if param (e.g. /admin/:id)  */
    if (\strpos($route, ':') !== false) {
      $parts_p = \explode('/', rtrim($this->registry['route'], '/'));
      $parts_r = \explode('/', $route);
      if (\count($parts_p) == \count($parts_r)) {
        return $this->registry['route'] = "/$path";
      }
    }
  }
});

// Fired at the nearly end of the {{ $app->run() }} routine
$app->on('after', function() {
  // activate maintenance mode if a ".maintenance" is found (within current dir)
  if (file_exists('.maintenance')) {
    // TODO: how to bypass maintenance when user is logged in? (eg. {{ cockpit('cockpit')->getUser() }} )
    $this->response->status = 503;
  }
  // try to guess "Content-Type" response header based on route extension (eg. "sitemap.xml" --> xml)
  if($this->response->mime === 'html' && $this->response->status >= 200 && $this->response->status < 400 && $this->req_is('ajax') == false) {
    $ext = \strtolower(\pathinfo($this->request->route, PATHINFO_EXTENSION));
    $this->response->mime = isset($this->response::$mimeTypes[$ext]) ? $ext : 'html';
  }
  switch ($this->response->status) {
    // file not found
    case 404:
      if($this->req_is('ajax')) {
        $this->response->body = json_encode(['status' => 404, 'message' => $this('i18n')->get('Not Found')]);
      } else {
        $this->viewvars['page'] = [
          'title' => $this('i18n')->get('404 Not Found'),
          'meta.robots' => 'noindex nofollow noarchive'
        ];
        $this->response->mime = 'html';
        $this->response->body = $this->view('views:404.php');
      }
      break;
    // maintenance
    case 503:
      if($this->req_is('ajax')) {
        $this->response->body = json_encode(['status' => 503, 'message' => $this('i18n')->get('Briefly unavailable for scheduled maintenance. Check back in a minute.')]);
      } else {
        $this->response->mime = 'html';
        $this->response->body = $this->view('views:maintenance.php');
      }
      $this->response->headers[] = 'Retry-After: 3000'; // date or milliseconds
      break;
  }

  // Add some debug info to response (network panel)
  if($this['debug.info'] && $this['debug'] && !headers_sent()) {
    header('X-Debug-Time: '.round(microtime(true) - START_TIME, 6).'sec');
    header('X-Debug-Memory: '.round(memory_get_peak_usage(false)/1024/1024, 2).'mb');
    header('X-Debug-Files: '.count(get_included_files()));
  }
});

/**
 * Module HOOKS (backend)
 *
 * @see { cockpit/modules/Collections/bootstrap.php }
 */

// Fired at the beginning of the {{ cockpit('collections')->find($collection, $options = []) }} function
$cockpit->on('collections.find.before', function($name, &$options) {
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
});

// Fired at the end of the {{ cockpit('collections')->find($collection, $options = []) }} function
$cockpit->on('collections.find.after', function($name, &$entries) {

});

/**
 * Start Lime App
 *
 * use {{ $app->run('/*'); }} if you wish to do things before dispatching yourself the {{ $app->render_route($route); }}
 *
 * @see { Lime/App }
 */
$app->run();
