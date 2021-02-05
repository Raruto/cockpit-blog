<?php
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

    $content = preg_replace_callback('/\B@(\w+)([ \t]*)(\( ( (?>[^()]+) | (?3) )* \))?/x', function($match) use($replace) {
        if (trim($match[1]) && isset($replace[$match[1]])) {
            return str_replace('(expr)', isset($match[3]) ? $match[3] : '()', $replace[$match[1]]);
        }
        return $match[0];
    }, $content);

    return $content;

 });
