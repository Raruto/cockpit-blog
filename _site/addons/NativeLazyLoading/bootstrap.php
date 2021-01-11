<?php
/**
 * Cockpit native lazy loading addon
 *
 * @see https://web.dev/browser-level-image-lazy-loading/
 *
 * @author  Raruto
 * @package cockpit-blog
 * @license MIT
 */

/**
 * Automatically add img[loading="lazy"] attribute ("html" and "wysiwyg" editor)
 */
if (COCKPIT_ADMIN && !COCKPIT_API_REQUEST) {
  $this->on('admin.init', function() {
    // load custom js
    $this->helper('admin')->addAssets([
        __DIR__ . '/assets/editor.js',
    ]);
  });
}
