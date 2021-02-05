<?php

if (defined('COCKPIT_FRONTEND') && COCKPIT_FRONTEND) {

$app->on('site.init', function() {

    // Fired at the nearly end of the {{ $app->run() }} routine
    $this->on('after', function() {

        // activate maintenance mode if a ".maintenance" is found (within current dir)
        if (file_exists(COCKPIT_SITE_DIR.'/.maintenance')) {
          $user = cockpit('cockpit')->getUser();
          // bypass maintenance when user is logged in
          if (empty($user) || empty($user['active'])) {
            $this->response->status = 503;
          }
        }

        switch ($this->response->status) {
            // file not found
            case 404:
                if($this->req_is('ajax')) {
                    $this->response->body = json_encode(['status' => 404, 'message' => $this('i18n')->get('Not Found')]);
                } else {
                    $this->viewvars['page'] = [
                        'title' => $this('i18n')->get('404 Not Found'),
                        'meta.robots' => 'noindex nofollow noarchive'
                    ];
                    $this->response->mime = 'html';
                    $this->response->body = $this->view('maintenancemode:views/404.php');
                }
                break;
            // maintenance
            case 503:
                if($this->req_is('ajax')) {
                    $this->response->body = json_encode(['status' => 503, 'message' => $this('i18n')->get('Briefly unavailable for scheduled maintenance. Check back in a minute.')]);
                } else {
                    $this->response->mime = 'html';
                    $this->response->body = $this->view('maintenancemode:views/maintenance.php');
                }
                $this->response->headers[] = 'Retry-After: 3000'; // date or milliseconds
                break;
        }

    }, 100);

});

}
