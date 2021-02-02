<?php
/**
 * Custom template HOOKS
 *
 * use {{ @trigger('custom.hook.name') }} inside template files for firing your custom event
 *
 * @see { layouts:base.php }
 */

// After opening <body> tag
// $app->on('site.header.scripts', function() { });

// Beside {{ $content_for_layout }} variable
$app->on('site.contentbefore', function() { echo '<main>'; });
$app->on('site.contentafter',  function() { echo '</main>'; });

// Before closing </body> tag
// $app->on('site.footer', function() { });

$app->on('sitemap.head',   function() { $this->renderView('partials:sitemap-head.php'); });
$app->on('sitemap.footer', function() { $this->renderView('partials:sitemap-footer.php'); });
