<?php
/**
 * Cockpit extended ui addon
 *
 * @author     Raruto
 * @package    cockpit-blog
 * @license    MIT
 *
 * @see https://github.com/pauloamgomes/CockpitCMS-Helpers
 */

if (COCKPIT_ADMIN && !COCKPIT_API_REQUEST) {
  $this->on('admin.init', function () {

    // helper dropdown links in system menu
    if ($this->module('cockpit')->isSuperAdmin()) {
      $this->helper('admin')->addAssets('extendedui:assets/cp-quickactions.tag');
      $this->helper('admin')->addAssets('extendedui:assets/quickactions.js');
    }

    // link to website in system menu
    $this->on('cockpit.menu.system', function() {
      $this->renderView('extendedui:views/system.menu.php');
    });

  });
}
