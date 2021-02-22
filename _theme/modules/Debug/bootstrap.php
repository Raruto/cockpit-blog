<?php
/**
 * Cockpit app debug addon
 *
 * @author  Raruto
 * @package cockpit-blog
 * @license MIT
 */

$app->on('site.init', function() {

    // Before closing </body> tag
    $this->on('site.footer', function() {

        // print some debug info
        if ($this['debug.info']) {
            $this->renderView('theme-debug:views/debug.php');
        }

    });

    // Fired at the nearly end of the {{ $app->run() }} routine
    $this->on('after', function() {

        // Add some debug info to response (network panel)
        if ($this['debug.info'] && $this['debug'] && !headers_sent()) {
            header('X-Debug-Time: '.round(microtime(true) - START_TIME, 6).'sec');
            header('X-Debug-Memory: '.round(memory_get_peak_usage(false)/1024/1024, 2).'mb');
            header('X-Debug-Files: '.count(get_included_files()));
        }

    }, -99999);

});
