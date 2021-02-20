<?php
/**
 * Cockpit collections addon
 *
 * @author  Raruto
 * @package cockpit-blog
 * @license MIT
 */

/**
 * Lime HOOKS (frontend)
 *
 * @see { LimeExtra/App | Lime/App }
 */

$app->on('site.init', function() use (&$app) {

    /**
     * Module HOOKS (backend)
     *
     * @see { cockpit/modules/Collections/bootstrap.php }
     */

    // Fired at the beginning of the {{ cockpit('collections')->find($collection, $options = []) }} function
    cockpit()->on(
        [
            'collections.find.before.posts',
            'collections.find.before.pages'
        ],
        function($name, &$options) {
            // set default "filter" to published
            if (!isset($options['filter'])) {
                $options['filter'] = [ 'published' => true ];
            } else if( !isset($options['filter']['published']) ) {
                $options['filter']['published'] = true;
            }
            // set default "sort" order to created
            if (!isset($options['sort'])) {
                $options['sort'] = [ '_created' => -1 ];
            } else if( !isset($options['sort']['_created']) ) {
                $options['sort']['_created'] = -1;
            }
        }
    );

    // Fired at the end of the {{ cockpit('collections')->find($collection, $options = []) }} function
    cockpit()->on('collections.find.after', function($name, &$entries) use ($app) {
        foreach ($entries as $k => $entry) {
            if (isset($entry['content'])) {
                // render lexy code @snippets
                $entries[$k]['content'] = $app->renderer->execute($entries[$k]['content'], $app->viewvars);
            }
        }
    });

});
