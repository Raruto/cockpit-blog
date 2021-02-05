<?php

// Test page
$app->bind('/api/test', function() {
    $this->response->mime = 'json';
    return json_encode(['status' => 200, 'message' => $this('i18n')->get('It works!')]);
});
