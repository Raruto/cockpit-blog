<?php
/**
 * Cockpit PWA addon
 *
 * @author  Raruto
 * @package cockpit-blog
 * @license MIT
 */

$app->on('site.init', function() use ($app) {

    // Manifest
    $app->bind('/manifest.json', function() {
        return $this->view('pwa:views/manifest.json');
    });

    // Service Worker [PWA]
    $app->bind('/sw.js', function() {
        return $this->view('pwa:views/sw.js');
    });

    // inject service worker code
    $app->on('site.footer', function() {
        echo "<script>{$this->view('pwa:views/sw-register.js')}</script>";
    });

});
