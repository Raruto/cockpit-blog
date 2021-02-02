<?php

$app->on('site.init', function() use($app) {

    // escape php short tags
    $app->renderer->extend(function($content) {
        return preg_replace('/(\s*)@(\<\?|\?\>)(\s*)/', '<?php echo "$2" ?>', $content);
     });

    // Sitemap [index]
    $app->bind('/sitemap.xml', function() {
        $this->response->mime = 'xml';
        return $this->view('theme-sitemaps:views/layouts/sitemap.xml');
    });

    // Sitemap [xsl]
    $app->bind('/sitemap.xsl', function() {
        $this->response->mime = 'xml';
        return $this->view('theme-sitemaps:views/layouts/sitemap.xsl');
    });

    // Sitemap [posts, pages, ...]
    $app->bind('#/([\w]+)-sitemap.xml#', function($params) {
        $this->response->mime = 'xml';
        $collection = cockpit('collections')->collection($params[':captures'][0] ?? '');
        if (empty($collection) || empty($collection['has_sitemap'])) {
          $this->reroute('/sitemap.xml');
        }
        return $this->view('theme-sitemaps:views/layouts/collection.xml', [ 'id' => $collection['_id'], 'base_slug' => $collection['base_slug'] ?? '' ]);
    });

    // Robots
    $app->bind('/robots.txt', function() use (&$app) {
      $this->response->mime = 'txt';
      return $app->view('theme-sitemaps:views/layouts/robots.txt');
    }, '/' === $app['base_url'] /* display robots.txt only if we are in top-level directory of the host. */ );


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
        return $this->view("theme-sitemaps:views/layouts/feed.$ext", [ 'id' => $collection['_id'], 'base_slug' => $collection['base_slug'] ?? '' ]);
    });

}, 100);


if (defined('COCKPIT_ADMIN') && COCKPIT_ADMIN) {

    // Collection settings
    $app->on('collections.settings.aside', function() {
      $this->renderView( 'theme-sitemaps:views/collection.settings.php' );
    });

}
