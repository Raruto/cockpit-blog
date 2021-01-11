<?php
/**
 * Simple installer page.
 *
 * @author  Raruto
 * @package cockpit-blog
 * @license MIT
 */

// cockpit admin folder.
$COCKPIT     = 'admin';
$COCKPIT_DIR = '../' . $COCKPIT;

// list here your dependencies.
$repos = [
  [
    'repo'          => 'agentejo/cockpit',
    'version'       => '0.11.2',
    'dest'          => $COCKPIT_DIR ,
    'force_update'  => !file_exists( $COCKPIT_DIR . '/bootstrap.php' )
  ]
];

// shutdown stuff.
$error       = false;
$autodelete  = [
  __DIR__ . "/$COCKPIT_DIR/storage",
  __DIR__ . "/$COCKPIT_DIR/addons"
];

// php execution limit (0 = no limit).
@set_time_limit( 0 );

// print errors.
if ( is_localhost() ) {
 ini_set( 'display_errors', 1 );
 ini_set( 'display_startup_errors', 1 );
 error_reporting( E_ALL );
}

// minimum system checks.
if ( version_compare( PHP_VERSION, '7.1.0' ) < 0 ) {
   echo "Your PHP version is $php_version - too old!";
   exit();
}

// automatically delete install folder on complete.
\register_shutdown_function(function() {
  global $error;
  $e = error_get_last();
  if ( ( isset($e) && $e['type'] === E_ERROR ) || $error == true ) return;
  if ( ! is_localhost() ) {
    rrmdir( __DIR__ );
  }
  global $autodelete;
  foreach( $autodelete as $file ) {
    if( is_dir( $file ) ) {
      rrmdir( $file );
    } else if ( file_exists( $file ) ) {
      unlink( $file );
    }
  }
});

/**
 * Download a remote resource
 *
 * @param  string $url    remote file url.
 * @param  string $folder folder where to download the remote resource.
 * @param  string $file   file onto download the remote resource.
 * @return void
 */
function download_remote_file( $url, $folder, $file ) {
  if ( ! is_dir( $folder ) ) {
    mkdir( $folder, 0755, true );
  }

  $fp = fopen( $file, 'wb' );

  $ch = curl_init( $url );
  curl_setopt( $ch, CURLOPT_FILE, $fp );
  curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
  curl_setopt( $ch, CURLOPT_HEADER, 0 );

  if ( is_localhost() ) {
    curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
  }

  curl_exec( $ch );
  curl_close( $ch );

  fflush( $fp );
  fclose( $fp );
}

/**
 * Check if a remote resource exists
 *
 * @param  string $url remote file url.
 * @return bool
 */
function remote_file_exists( $url ) {
  $ch = curl_init( $url );
  curl_setopt( $ch, CURLOPT_NOBODY, true );
  curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );

  if ( is_localhost() ) {
    curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
  }

  curl_exec( $ch );
  $http_code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
  curl_close( $ch );

  if ( $http_code == 200 ) {
    return true;
  }
  return false;
}

/**
 * Check if this a local Server instance.
 */
function is_localhost() {
  return in_array( $_SERVER['REMOTE_ADDR'] ?? null, [ '127.0.0.1', '::1' ], true );
}

/**
 * Unzip a local file
 *
 * @param  string $file local file path.
 * @param  string $dest folder where to unzip.
 * @return void
 */
function unzip_file( $file, $dest ) {
  $zip = new \ZipArchive;
  $zip->open($file);
  $zip->extractTo($dest);
  $zip->close();
}

/**
 * Helper function used to immediately send text to browser.
 *
 * @param  string $txt message to show
 * @return void
 */
function echo_flush( $txt ){
  if ( ob_get_level() == 0 ) ob_start();
  echo $txt;
  print str_pad( '', 4096 ) . "\n";
  ob_flush();
  flush();
}
/**
 * Recursively delete folder and its content.
 *
 * @param  string $dir folder path.
 * @return void
 */
function rrmdir( $dir ) {
  foreach( glob($dir . '/{,.}*[!.]', GLOB_MARK | GLOB_BRACE) as $file ) {
    if( is_dir( $file ) ) rrmdir( $file );
    else unlink( $file );
  }
  var_dump( $dir );
  \rmdir( $dir );
}

/**
 * Recursive copy function
 *
 * @param  string $path folder path.
 * @param  string $dest folder path.
 * @return boolean true on success
 */
function rrename( $path, $dest ) {
  $items = scandir( $path );
  if (is_dir($path)) {
    if ( !is_dir( $dest ) ) {
      mkdir($dest, 0755);
    }

    if ( sizeof($items) > 0 ) {
      foreach( $items as $file ) {
        if ( $file == "." || $file == ".." ) continue;
          if ( is_dir("{$path}/{$file}") ) {
            rrename( "{$path}/{$file}", "{$dest}/{$file}" );
          } else {
            \copy( "{$path}/{$file}", "{$dest}/{$file}" );
            // echo_flush( "copied: {$dest}/{$file}" );
          }
        }
      }
    return true;
  } else if ( is_file($path) ) {
      return \copy( $path, $dest );
  }
  return false;
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>System installation</title>
    <link rel="stylesheet" href="../css/app.css">
    <!-- redirect to cockpit install folder on complete. -->
    <meta http-equiv="refresh" content="3;url=../<?php echo $COCKPIT; ?>/install">
  </head>
  <body>
    <pre><?php
      foreach( $repos as $repo ) {
        $folder  = "tmp";
        $name    = explode('/', $repo['repo'])[1] . '-' . $repo['version'];
        $file    = "$folder/$name.zip";
        $dest    = $repo['dest'];
        $url     = $repo['url'] ?? 'https://github.com/'. $repo['repo'] . '/archive/' . $repo['version'] . '.zip';
        $i       = 0;

        try {

          /* step 0 */
          if ( is_dir( "$dest" ) ) {
            if ( empty($repo['force_update']) ) {
              echo_flush( "$dest folder already exists, skipping.\n" );
              continue;
            } else if( !is_writable("$dest") ) {
              chmod("$dest", 0777);
            }
          }

          /* step 1 */
          if ( ! is_file( $file ) && ! is_dir( "$folder/$name" ) && remote_file_exists( $url ) ) {
            $i++;
            echo_flush( "$i) Downloading $url\n" );
            download_remote_file( $url, $folder, $file );
          }

          /* step 2 */
          if ( is_file( $file ) && ! is_dir( "$folder/$name" ) ) {
            $i++;
            echo_flush( "$i) Extracting $name.zip\n" );
            unzip_file( $file, $folder );
          }

          /* step 3 */
          if ( is_dir( "$folder/$name" ) /*&& ! is_dir( "$dest" )*/  ) {
            $i++;
            echo_flush( "$i) Moving to $dest\n" );
            rrename( "$folder/$name", "$dest" );
          }

          /* step 4 */
          if ( is_file( $file ) ) {
            $i++;
            echo_flush( "$i) Deleting $name.zip\n" );
            unlink( $file );
          }

          /* step 5 */
          if ( is_dir( $folder ) ) {
            $i++;
            echo_flush( "$i) Deleting $folder folder\n" );
            rrmdir( $folder );
          }

        } catch ( Exception $e ) {
          $error = true;
          echo_flush( "error: $e" );
        }
      }

      echo_flush( "Bye!\n" );

    ?></pre>
  </body>
</html>
