<?php
/**
 * Custom API endpoint (with token)
 *
 * @link https://discourse.getcockpit.com/t/how-to-create-custom-api-endpoints/202/4
 * @link https://github.com/raffaelj/cockpit-scripts/tree/master/custom-api-endpoints
 */

$token = $this->param('token');

if (!$token) {
    return false;
}

return [ 'message' => 'It works!' ];
