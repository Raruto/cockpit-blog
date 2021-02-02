<?php
/**
 * Set CACHE folder
 *
 * @see { Lime/App | Lime/Helper/Cache | cockpit/lib/Lexy.php | cockpit/bootstrap.php }
 */
if (defined('COCKPIT_FRONTEND') && COCKPIT_FRONTEND) {

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

}
