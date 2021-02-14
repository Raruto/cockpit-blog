<?php
/**
 * Cockpit matomo addon
 *
 * @author  Raruto
 * @package cockpit-blog
 * @license MIT
 */

$app->module('matomo')->extend([

    'render' => function() {

        // inject matomo tracking code
        if(!isset($this->app['matomo']) || !empty($this->app['matomo'])) {
            $url = $app['matomo.url'] ?? (cockpit()->getSiteUrl(true).'/analytics/matomo/');
            $id  = isset($app['matomo.id']) ? $app['matomo.id'] : '1';
            echo "<script>{$this->app->view('matomo:views/matomo.js', compact('url', 'id'))}</script>";
        }

    }

]);
