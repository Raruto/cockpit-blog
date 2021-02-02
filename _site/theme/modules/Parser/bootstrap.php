<?php
/**
 * Extend Lexy Parser (templating engine)
 *
 * @link https://cpmultiplane.rlj.me/en/docs/lexy with available language structures
 * @see { cockpit/lib/Lexy.php | cockpit/bootsrap.php }
 */
if (defined('COCKPIT_FRONTEND') && COCKPIT_FRONTEND) {

    $app->renderer->extend(function($content) {
        $replace = [
          'dump'     => '<?php echo highlight_str(expr); ?>',                       // @dump(expr)
          'json'     => '<?php echo json_encode(expr); ?>',                         // @json(expr)
        ];

        $content = preg_replace('/(\s*)@(\<\?|\?\>)(\s*)/', '<?php echo "$2" ?>', $content); // escape php short tags

        $content = preg_replace_callback('/\B@(\w+)([ \t]*)(\( ( (?>[^()]+) | (?3) )* \))?/x', function($match) use($replace) {
          if (isset($match[3]) && trim($match[1]) && isset($replace[$match[1]])) {
            return str_replace('(expr)', $match[3], $replace[$match[1]]);
          }
          return $match[0];
        }, $content);

        return $content;
     });

    // Extend Lexy Parser
    $app->renderer->extend(function($content) {

       $replace = [
           'form'    => '<?php cockpit()->module("forms")->open(expr); ?>', // @form(expr)
           'endform' => '<?php cockpit()->module("forms")->close(expr); ?>', // @endform(expr)
       ];

       $content = preg_replace_callback('/\B@(\w+)([ \t]*)(\( ( (?>[^()]+) | (?3) )* \))?/x', function($match) use($replace) {
           if (trim($match[1]) && isset($replace[$match[1]])) {
               return str_replace('(expr)', isset($match[3]) ? $match[3] : '()', $replace[$match[1]]);
           }
           return $match[0];
       }, $content);

       return $content;

    });

}
