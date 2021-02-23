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
if (PHP_SAPI == 'cli-server') {

    $url   = parse_url($_SERVER['REQUEST_URI']);
    $ext   = pathinfo($_SERVER['SCRIPT_FILENAME'])['extension'];
    $file  = $_SERVER['SCRIPT_FILENAME'];

    /* "dot" routes (see: https://bugs.php.net/bug.php?id=61286) */
    $_SERVER['PATH_INFO'] = str_replace('/', DIRECTORY_SEPARATOR, $url['path']);

    /* static files (eg. assets/app/css/style.css) */
    if (is_file($file)) {

        // custom Mime Types
        if ($ext == 'tag') {
            header('Content-Type: application/javascript');
            readfile($file);
            exit;
        }

        // default Mime Types.
        if ($ext != 'php') {
          return false;
        }

    }

    $index = $_SERVER['PATH_INFO'] . DIRECTORY_SEPARATOR . 'index.php';

    // Trasverse directories and search for "index.php"
    $path  = dirname($index);
    do {
      if (is_file(__DIR__ . $path . DIRECTORY_SEPARATOR . 'index.php')) {
        $index = $path . DIRECTORY_SEPARATOR . 'index.php';
        break;
      }
      $path = dirname($path);
    } while ($path !== DIRECTORY_SEPARATOR && $path !== '.');

    // Update $_SERVER variables to point to the correct index-file.
    $_SERVER['SCRIPT_FILENAME'] = $_SERVER['DOCUMENT_ROOT'] . $index;
    $_SERVER['SCRIPT_NAME']     = $index;
    $_SERVER['PHP_SELF']        = $index;

    /* index files (eg. install/index.php) */
    if (is_file($_SERVER['SCRIPT_FILENAME'])) {

      include_once($_SERVER['SCRIPT_FILENAME']);

      // custom "index.php"
      if (dirname($_SERVER['SCRIPT_NAME']) != DIRECTORY_SEPARATOR) {
        exit;
      }

    }
}
