<?php

$app->on('site.init', function() use ($app) {

  // Manifest
  $app->bind('/manifest.json', function() use (&$app) {
      return $app->view('theme-pwa:views/manifest.json');
  });

  // Service Worker [PWA]
  $app->bind('/sw.js', function() use (&$app) {
      return $app->view('theme-pwa:views/sw.js');
  });

  // inject service worker code
  $app->on('site.footer', function() use ($app) {
      echo "<script>{$this->view('theme-pwa:views/sw-register.js')}</script>";
  });

});
