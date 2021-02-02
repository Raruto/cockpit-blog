<?php
/**
 * Lime HOOKS (frontend)
 *
 * @see { LimeExtra/App | Lime/App }
 */

$app->on('site.init', function() use (&$app) {

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
      // try to guess "Content-Type" response header based on route extension (eg. "sitemap.xml" --> xml)
      if($this->response->mime === 'html' && $this->response->status >= 200 && $this->response->status < 400 && $this->req_is('ajax') == false) {
        $ext = \strtolower(\pathinfo($this->request->route, PATHINFO_EXTENSION));
        $this->response->mime = isset($this->response::$mimeTypes[$ext]) ? $ext : 'html';
      }
    });

    /**
     * Module HOOKS (backend)
     *
     * @see { cockpit/modules/Collections/bootstrap.php }
     */

    // Fired at the beginning of the {{ cockpit('collections')->find($collection, $options = []) }} function
    cockpit()->on('collections.find.before', function($name, &$options) {
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

});
