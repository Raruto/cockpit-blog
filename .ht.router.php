<?php
/**
 * Routing-script for the built-in PHP web server.
 *
 * @author  Raruto
 * @package cockpit-blog
 * @license MIT
 *
 * @see http://php.net/manual/en/features.commandline.webserver.php
 */

// handle php webserver (dev-only) [ php -S localhost:8080 index.php ]
if ( PHP_SAPI == 'cli-server' ) {
  $path  = pathinfo( $_SERVER["SCRIPT_FILENAME"] );
  $index = realpath( $path['dirname'] . '/index.php' );
  $file  = $_SERVER["SCRIPT_FILENAME"];
  /* "dot" routes (see: https://bugs.php.net/bug.php?id=61286) */
  $_SERVER['PATH_INFO'] = $_SERVER['REQUEST_URI'];
  /* static files (eg. css/app.css) */
  if ( is_file( $file ) && $path["extension"] != "php" ) {
    if ( $path["extension"] == "tag" ) {
      header( "Content-Type: application/javascript" );
      readfile( $file );
      exit;
    }
    return false;
  }
  /* admin routes (eg. admin/api/get/collection/posts) */
  if ( strpos( rtrim( $_SERVER['REQUEST_URI'], '/') . '/', '/'. COCKPIT . '/' ) === 0 ) {
    str_replace( "/". COCKPIT, '', $_SERVER['REQUEST_URI'] );
    str_replace( "/". COCKPIT, '', $_SERVER['PATH_INFO'] );
    include_once( is_file( $index ) ? $index : COCKPIT . '/index.php');
    exit;
  }
  /* index files (eg. install/index.php) */
  if ( is_file( $index ) ) {
    include_once( $index );
  }
}
