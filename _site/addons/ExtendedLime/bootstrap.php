<?php
/**
 * Cockpit extended lime addon
 *
 * @author  Raruto
 * @package cockpit-blog
 * @license MIT
 */

/**
 * Fallback for un-registered routes when url ends with "/"
 *
 * @example "/hello/" --> /hello
 */

# Fired at the beginning of the {{ $app->run() }} routine
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

/**
 * Set "Content-Type" response header based on route extension
 *
 * @example "sitemap.xml" --> xml
 */

# Fired at the nearly end of the {{ $app->run() }} routine
$app->on('after', function() {

    // try to guess "Content-Type" response header based on route extension (eg. "sitemap.xml" --> xml)
    if($this->response->mime === 'html' && $this->response->status >= 200 && $this->response->status < 400 && $this->req_is('ajax') == false) {
        $ext = \strtolower(\pathinfo($this->request->route, PATHINFO_EXTENSION));
        $this->response->mime = isset($this->response::$mimeTypes[$ext]) ? $ext : 'html';
    }

});

/**
 * Extend Lexy Parser (templating engine)
 *
 * @link https://cpmultiplane.rlj.me/en/docs/lexy with available language structures
 * @see { cockpit/lib/Lexy.php | cockpit/bootsrap.php }
 */

// retrieve user defined extensions
$extensions = cockpit()->retrieve('lexy/extensions', []);

// retrieve user defined extensions (regex pattern)
$_extensions = [];
foreach( $extensions as $pattern => $replace ) {
    if (\substr($pattern,0,1) == '/' && \substr($pattern,-1) == '/') {
      $_extensions[$pattern] = $replace;
      unset($extensions[$pattern]);
    }
}

$app->renderer->extend(function($content) use ($extensions, $_extensions) {

    // regex extensions
    foreach( $_extensions as $pattern => $replace ) {
        $content = preg_replace($pattern, $replace, $content);
    }

    // regular extensions
    $replace = $extensions;

    $content = preg_replace_callback('/\B@(\w+)([ \t]*)(\( ( (?>[^()]+)
| (?3) )* \))?/x', function($match) use($replace) {
if (trim($match[1]) && isset($replace[$match[1]])) {
return str_replace('(expr)', isset($match[3]) ? $match[3] : '()', $replace[$match[1]]);
}
return $match[0];
}, $content);

return $content;

});
