<?php

cockpit()->module('snippets')->extend([

  'render' => function($name, $slots = []) {
      $snippet = cockpit()->module('collections')->findOne('snippets', [ 'id' => $name ], ['code' => 1]);
      if(!empty($snippet)) echo cockpit()->renderer->execute($snippet['code'], array_merge(cockpit()->viewvars, $slots));
  }

]);


// Extend Lexy Parser
$app->renderer->extend(function($content) {

   $replace = [
      'snippet'  => '<?php cockpit()->module("snippets")->render(expr); ?>', // @snippet(expr)
   ];

   $content = preg_replace_callback('/\B@(\w+)([ \t]*)(\( ( (?>[^()]+) | (?3) )* \))?/x', function($match) use($replace) {
      if (trim($match[1]) && isset($replace[$match[1]])) {
          return str_replace('(expr)', isset($match[3]) ? $match[3] : '()', $replace[$match[1]]);
      }
      return $match[0];
  }, $content);

  return $content;

});
