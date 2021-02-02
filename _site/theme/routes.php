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
