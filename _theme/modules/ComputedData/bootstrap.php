<?php
/**
 * Cockpit computed data addon
 *
 * @author  Raruto
 * @package cockpit-blog
 * @license MIT
 */

$app->on('site.init', function() use (&$app) {

    // Fired at the beginning of the {{ $app->view() }} rendering function
    $app->on('app.render.view', function(&$template, &$slots) use (&$app) {
        // make $page variable globally available in template files
        $page = $slots['page'] ?? [];
        if( !empty($page) ) {
            $this->viewvars['page'] = $page = array_replace_recursive([
                'title'          => '',
                'description'    => $app['app.description'] ?? '',
                'meta.robots'    => $app['meta.robots'] ?? '',
            ], $page);
        }
    });

});
