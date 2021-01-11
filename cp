#!/usr/bin/env php
<?php

if (PHP_SAPI !== 'cli') {
    exit('Script needs to be run from Command Line Interface (cli)');
}
/**
 * Just a simple "cp" shortcut
 *
 * the following folders are autoloaded by cockpit:
 *
 * - cockpit/modules/Cockpit/cli
 * - cockpit/modules/Collections/cli
 * - cockpit/modules/Forms/cli
 * - cockpit/modules/Singletons/cli
 *
 * @see { cockpit->paths('#cli') } to check all the available cli dirs
 */

include_once('admin/cp');
