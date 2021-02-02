<?php

$app->on('site.init', function() {

    // After opening <body> tag
    $this->on('site.header.scripts', function() {
        // inject matomo tracking code
        if(!isset($this['matomo']) || !empty($this['matomo'])) {
            $url = $app['matomo.url'] ?? ( cockpit()->getSiteUrl(true) . '/analytics/matomo/' );
            $id  = isset($app['matomo.id']) ? $app['matomo.id'] : '1';
            echo "<script>{$this->view('theme-matomo:views/matomo.js', compact('url', 'id'))}</script>";
        }
    });

});
