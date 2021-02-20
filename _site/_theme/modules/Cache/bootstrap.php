<?php
/**
 * Cockpit app cache addon
 *
 * @author  Raruto
 * @package cockpit-blog
 * @license MIT
 */

/**
 * Set CACHE folder
 *
 * @see { Lime/App | Lime/Helper/Cache | cockpit/lib/Lexy.php | cockpit/bootstrap.php }
 */

if (!empty($app['debug']) && defined('COCKPIT_FRONTEND') && COCKPIT_FRONTEND) {
    $CACHE_DIR = $app->path('#cache:');       // eg. "_site/cache"
    $app('cache')->setCachePath($CACHE_DIR);  // *.cache.php
    $app->renderer->setCachePath($CACHE_DIR); // *.lexy.php
}

$CLEAR_CACHE = function($app) {
  $cached = [ $app->path('#cache:'), $app->path('#tmp:') ];
  foreach ( $cached as $cache) {
      $folder = new \FilesystemIterator($cache, FilesystemIterator::SKIP_DOTS);
      foreach ( $folder as $item) {
          // skip hidden files and directories
          if ($item->getFilename()[0] !== '.') {
              $app('fs')->delete($item->getRealPath());
          }
      }
  }
};

// Helper route to empty cache folder
$app->bind('/api/clearcache', function($params) use (&$app, $CLEAR_CACHE) {
    $CLEAR_CACHE($app);
    $this->response->mime = 'json';
    return json_encode(['status' => 200, 'message' => $this('i18n')->get('It works!')]);
});

if(!empty($app['debug'])) {
  $CLEAR_CACHE($app);
}
