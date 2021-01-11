<?php
/**
 * Cockpit sample data installer addon
 *
 * @author  Raruto
 * @package cockpit-blog
 * @license MIT
 */

/**
 * Set default langauge for "admin" user during app install.
 *
 * @todo submit a fixing pull request for: { cockpit/install/index.php#L82 }
 */
if ( defined( 'COCKPIT_INSTALL' ) && COCKPIT_INSTALL ) {
  \register_shutdown_function(function() use(&$app) {
    $accounts = $app->storage->find('cockpit/accounts');
    $language = $app->helper('i18n')->locale;
    foreach($accounts as $account) {
      $account['i18n']      = $language;
      $account['_modified'] = time();
      $app->storage->save('cockpit/accounts', $account);
    }
  });
}

/**
 * Set collection data user during app install.
 */
if ( defined( 'COCKPIT_INSTALL' ) && COCKPIT_INSTALL ) {
  \register_shutdown_function(function() use(&$app) {
    $collections = $app->module('collections')->collections();
    foreach ( $collections as $name => $collection ) {
      $demo  = __DIR__ . "/data/$name.collection.json";
      $data  = $app->helper('fs')->read( $demo );
      $items = json_decode( $data, true );
      if ( $items ) {
        $cid = $collection['_id'];
        foreach ($items as &$item) {
          if ( !$app->storage->count( "collections/{$cid}", [ '_id' => $item['_id'] ] ) ) {
            $app->storage->insert( "collections/{$cid}", $item );
          }
        }
      }
    }
    $app->helper('fs')->copy( __DIR__ . '/uploads', "#uploads:" );
  });
}
