<?php
/**
 * The following constants are always loaded in both ("Frontend" and "Backend") enviroments
 */

/** Absolute path to web root folder ( like: COCKPIT_SITE_DIR ) **/
define('ABSPATH', str_replace(DIRECTORY_SEPARATOR, '/', dirname(__DIR__)));

// check for custom defines
if (file_exists(ABSPATH.'/_site/defines.php')) {
    include(ABSPATH.'/_site/defines.php');
}

/** Cockpit folder name **/
if(!defined('COCKPIT'))                       define('COCKPIT', basename(__DIR__));

/** Move "config" folder to web root (eg. /admin/config --> /_site/config ) **/
if(!defined('COCKPIT_CONFIG_DIR'))            define('COCKPIT_CONFIG_DIR', ABSPATH . '/_site/config');

/** Move "storage" folder to web root (eg. /admin/storage --> /_site ) **/
if(!defined('COCKPIT_STORAGE_FOLDER'))        define('COCKPIT_STORAGE_FOLDER', ABSPATH . '/_site');

/* Move "uploads" folder to web root (eg. /admin/storage/uploads --> /media/uploads ) */
if(!defined('COCKPIT_PUBLIC_STORAGE_FOLDER')) define('COCKPIT_PUBLIC_STORAGE_FOLDER' , ABSPATH . '/media');

/** Show PHP errors */
if(defined('DEBUG_DISPLAY') && DEBUG_DISPLAY) {
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
}
