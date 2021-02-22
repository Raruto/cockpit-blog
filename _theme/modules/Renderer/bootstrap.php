<?php
/**
 * Cockpit renderer addon
 *
 * @author  Raruto
 * @package cockpit-blog
 * @license MIT
 */

// $app->module('renderer')->extend([
//
// ]);

$app->on('site.init', function() use (&$app) {

    // retrieve user defined routes
    $routes = cockpit()->retrieve('theme/routes', []);

    // loop user defined routes
    foreach ($routes as $route => $options) {

        // bind routes
        $app->bind($route, function($params) use (&$app, $route, $options) {

          // Page rewrites
          if (!empty($options['render'])) {
              return $app->render_route($options['render'], $params);
          }

          // Page Redirects
          if (!empty($options['redirect'])) {
              return $app->reroute($options['redirect']);
          }

          // Single Page
          if (!empty($options['collection']) && !empty($params['slug'])) {

              // search entries by slug
              $page = cockpit('collections')->findOne($options['collection'], [ 'slug' => $params['slug'] ]);

              if(!empty($page)) return $app->view($options['template'] ?? 'views:page.php', compact('page'));

              // fallback to blog pagination (:slug --> :splat)
              if(is_numeric($params['slug'])) {
                  return $app->render_route('/blog/*', [ ':splat' => [ substr($app['route'], 1) ] ] );
              }

          }

          // Archive page
          if (!empty($options['archive'])) {

              // set default pagenum ('1')
              if(empty($params[':splat'][0])) $params[':splat'][0] = '1';

              if(\strpos($options['archive'], ':')) {
                  list($collection, $tag) = \explode(':', $options['archive'], 2);
              } else{
                  $collection = $options['archive'];
              }

              // pagination route: "/blog/:pagenum"
              $parts     = explode('/',$params[':splat'][0], 2);
              $page      = [
                'title'      => $app('i18n')->getStr('%s Archive', [ ucfirst( $collection ) ]),
                'base_route' => rtrim(str_replace($params[':splat'][0], '', $app['route']), '/') . '/' . $parts[0],
                'collection' => $collection,
                'query'      => [
                    'filter' => [ 'published' => true /*, 'tags' => [ '$in' => [ $parts[0] ] ]*/ ],
                    'sort'   => [ '_created' => -1 ],
                    'skip'   => intval($parts[1] ?? 1) - 1,
                    'limit'  => intval($app['pagination.limit'] ?? 5)
                ]
              ];

              // Tag archive filter
              if (isset($tag)) {
                  $page['query']['filter']['tags'] = [ '$in' => [ $parts[0] ] ];
                  $page['title']                   = $app('i18n')->getStr('%s - %s Archive', [ ucfirst( $parts[0] ), ucfirst( $collection ) ]);
              }

              // Home archive pagination
              if (count($parts) == 1 && rtrim(str_replace($params[':splat'][0], '', $app['route']), '/') == '') {
                  $page['query']['skip']           = intval($parts[0] ?? 1) - 1;
              };

              return $app->view($options['template'] ?? 'views:archive.php', compact('page'));

          }

        });

    }

}, 100);
