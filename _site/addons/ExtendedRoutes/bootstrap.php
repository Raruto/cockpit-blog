<?php

// Fired at the beginning of the {{ $app->run() }} routine
$app->on('before', function() {

    // skip check if route is already registered (eg. "/login")
    if (isset($this->routes[$this->registry['route']])) return;

    // fallback for un-registered routes when url ends with "/"
    $path = trim($this->registry['route'], '/');

    /* eg. "/login/" --> "/login" */
    if (isset($this->routes["/$path"]))  return $this->registry['route'] = "/$path";

    /* eg. "/article/:slug/" --> "/article/:slug" */
    foreach ($this->routes as $route => $callback) {
        /* skip if regex (e.g. #\.html$#) */
        if (\substr($route,0,1)=='#' && \substr($route,-1)=='#') continue;
        /* skip if splat (e.g. /admin/*) */
        if (\strpos($route, '*') !== false) continue;
        /* check if param (e.g. /admin/:id)  */
        if (\strpos($route, ':') !== false) {
            $parts_p = \explode('/', rtrim($this->registry['route'], '/'));
            $parts_r = \explode('/', $route);
            if (\count($parts_p) == \count($parts_r)) {
                return $this->registry['route'] = "/$path";
            }
        }
    }

});

// Fired at the nearly end of the {{ $app->run() }} routine
$app->on('after', function() {

    // try to guess "Content-Type" response header based on route extension (eg. "sitemap.xml" --> xml)
    if($this->response->mime === 'html' && $this->response->status >= 200 && $this->response->status < 400 && $this->req_is('ajax') == false) {
        $ext = \strtolower(\pathinfo($this->request->route, PATHINFO_EXTENSION));
        $this->response->mime = isset($this->response::$mimeTypes[$ext]) ? $ext : 'html';
    }

});
