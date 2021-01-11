<?php
/**
 * Cockpit image optimizier addon
 *
 * @author     Paulo Gomes (2019), Raruto (2021)
 * @package    cockpit-blog
 * @subpackage CockpitCMS-ImageOptimizer
 * @license    MIT
 *
 * @source https://github.com/pauloamgomes/CockpitCMS-ImageOptimizer
 * @see { README.md } for usage info.
 *
 * CHANGES (01/21):
 * - code comments
 */

/**
 * TODO: check if it can be replaced with core Lime\App::$autoload
 */
require __DIR__ . '/vendor/autoload.php';

if (COCKPIT_ADMIN || COCKPIT_API_REQUEST) {
  include_once __DIR__ . '/actions.php';
}

// CLI includes.
if (COCKPIT_CLI) {
  $this->path('#cli', __DIR__ . '/cli');
}
