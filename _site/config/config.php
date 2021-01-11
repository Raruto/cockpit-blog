<?php
/**
 * These configs are always loaded in both ("Frontend" and "Backend") enviroments
 *
 * @link https://zeraton.gitlab.io/cockpit-docs/guide/basics/configuration.html
 */
return [

  // Base locale for content and application language.
  'i18n' => 'it',

  // List of supported languages for field localization (eg. title_en, title_it, ...).
  'languages' => [
    // 'default' => 'English'
    // 'it'      => 'Italian'
  ],

  // Add another "addons" folder in addition to default one (eg. /admin/addons <--> /_site/addons )
  'loadmodules' => [ dirname(__DIR__) . '/addons' ],

  // Autosave addon
  'autosave' => [
    'collections' => '*',
    'singletons'  => '*'
  ],

  // User groups
  'groups' => [
    'editor' => [
      'autosave' => true,
    ]
  ],

  // A key for encrypting storage/api.keys.php where api tokens are stored.
  // The file is encrypted using RC4 and converted to base64 before.
  // 'sec_key' => 'xxxxx-SiteSecKeyPleaseChangeMe-xxxxx',

];
