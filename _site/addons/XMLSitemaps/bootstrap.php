<?php

// if (defined('COCKPIT_FRONTEND') && COCKPIT_FRONTEND) {

    $app->on('site.init', function() use($app) {

        // escape php short tags
        $app->renderer->extend(function($content) {
            return preg_replace('/(\s*)@(\<\?|\?\>)(\s*)/', '<?php echo "$2" ?>', $content);
         });

        // Sitemap [index]
        $app->bind('/sitemap.xml', function() {
            $this->response->mime = 'xml';
            return $this->view('xmlsitemaps:views/layouts/sitemap.xml');
        });

        // Sitemap [xsl]
        $app->bind('/sitemap.xsl', function() {
            $this->response->mime = 'xml';
            return $this->view('xmlsitemaps:views/layouts/sitemap.xsl');
        });


        // Sitemap [posts, pages, ...]
        // $collections = cockpit('collections')->collections();
        // foreach ($collections as $collection) {
        //   if (empty($collection) || empty($collection['has_sitemap'])) {
        //       continue;
        //   }
        //   $id        = $collection['_id'];
        //   $base_slug = $collection['base_slug'] ?? '';
        //   $app->bind("/{$id}-sitemap.xml", function($params) use ($id, $base_slug) {
        //       $this->response->mime = 'xml';
        //       return $this->view('xmlsitemaps:views/layouts/collection.xml', compact('id', 'base_slug'));
        //   });
        // }

        // Sitemap [posts, pages, ...]
        $app->bind('#^\/([\w]+)\-sitemap\.xml$#', function($params) {
            $this->response->mime = 'xml';
            $collection = cockpit('collections')->collection($params[':captures'][0] ?? '');
            if (empty($collection) || empty($collection['has_sitemap'])) {
              $this->reroute('/sitemap.xml');
            }
            return $this->view('xmlsitemaps:views/layouts/collection.xml', [ 'id' => $collection['_id'], 'base_slug' => $collection['base_slug'] ?? '' ]);
        });

        // Robots
        $app->bind('/robots.txt', function() use (&$app) {
          $this->response->mime = 'txt';
          return $app->view('xmlsitemaps:views/layouts/robots.txt');
        }, '/' === $app['base_url'] /* display robots.txt only if we are in top-level directory of the host. */ );

    }, 1000);

// }

if (defined('COCKPIT_ADMIN') && COCKPIT_ADMIN) {

    // Collection settings
    $app->on('collections.settings.aside', function() {
      $this->renderView( 'xmlsitemaps:views/collection.settings.php' );
    });

}
