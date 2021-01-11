<?php
/**
 * Cockpit quick actions addon
 *
 * @author     Paulo Gomes (2019), Raruto (2021)
 * @package    cockpit-blog
 * @license    MIT
 *
 * @source https://github.com/pauloamgomes/CockpitCMS-Helpers
 */

if (COCKPIT_ADMIN && !COCKPIT_API_REQUEST) {
  $this->on('admin.init', function () use ($app) {
    if ($app->module('cockpit')->isSuperAdmin()) {
      $this->helper('admin')->addAssets('quickactions:assets/cp-quickactions.tag');
      $this->helper('admin')->addAssets('quickactions:assets/quickactions.js');
    }
  });
}
