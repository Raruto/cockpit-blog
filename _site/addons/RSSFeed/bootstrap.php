<?php

// if (defined('COCKPIT_FRONTEND') && COCKPIT_FRONTEND) {

    $app->on('site.init', function() use($app) {

      // Feed [json, xml]
      $app->bind('/feed/*', function($params) {
          if (count(explode('/', $params[':splat'][0] ?? '')) > 1) {
            return;
          }

          $path       = \pathinfo($params[':splat'][0] ?? 'feed.xml');
          $ext        = \strtolower($path['extension'] ?? 'xml');
          $id         = $path['filename'] == 'feed' ? 'posts' : $path['filename'];
          $collection = cockpit('collections')->collection($id);

          if (empty($collection) || empty($collection['has_feed']) || !in_array($ext, ['xml', 'json'])) {
              return $this->stop(404);
          }
          $this->response->mime = $ext;
          return $this->view("rssfeed:views/layouts/feed.$ext", [ 'id' => $collection['_id'], 'base_slug' => $collection['base_slug'] ?? '' ]);
      });

  }, 1000);

// }

if (defined('COCKPIT_ADMIN') && COCKPIT_ADMIN) {

    // Collection settings
    $app->on('collections.settings.aside', function() {
      $this->renderView( 'rssfeed:views/collection.settings.php' );
    });

}
