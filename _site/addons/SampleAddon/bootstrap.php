<?php
/**
 * Cockpit sample addon
 *
 * @author  Raruto
 * @package cockpit-blog
 * @license MIT
 *
 * @source https://github.com/Raruto/cockpit-sample-addon
 */

// Test page (REST API)
$app->bind('/api/test', function() {
    $this->response->mime = 'json';
    return json_encode(['status' => 200, 'message' => $this('i18n')->get('It works!')]);
});
