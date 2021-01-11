<?php
/**
 * Custom bootstrap.php file
 *
 * the following are autoloaded by cockpit:
 *
 * - #config:bootstrap.php                                        # custom bootstrap.php file
 * - #config:api/{$path}.php                                      # custom rest api endpoint (if token is mandatory)
 * - #config:api/public/{$path}.php                               # custom rest api endpoint (public access)
 * - #config:cockpit/i18n/{$lang}.php                             # custom locales
 * - #config:cockpit/style.css                                    # custom styles
 * - #config:collections/{$collection['name']}/views/entries.php  # custom collection entries template
 * - #config:collections/{$collection['name']}/views/entry.php    # custom collection entry template
 * - #config:forms/{$form}.php                                    # custom form validation
 * - #config:forms/emails/{$form}.php                             # custom email template
 * - #config:tags/{$component}.tag                                # custom uikit tag
 */

/**
* Pretty print php vars.
*
* @link https://www.php.net/manual/en/function.highlight-string.php#118550
*/
function highlight_str($text, $html = true) {
  $text = is_string($text) ? $text : print_r($text, true);
  if ( $html ) {
    // ini_set("highlight.comment", "#008000");
    // ini_set("highlight.default", "#000000");
    // ini_set("highlight.html", "#808080");
    // ini_set("highlight.keyword", "#0000BB; font-weight: bold");
    // ini_set("highlight.string", "#DD0000");
    $text = trim($text);
    // highlight_string() requires opening PHP tag or otherwise it will not colorize the text
    $text = highlight_string("<?php " . $text, true);
    $text = trim($text);
    // remove prefix
    $text = preg_replace("|^\\<code\\>\\<span style\\=\"color\\: #[a-fA-F0-9]{0,6}\"\\>|", "", $text, 1);
    // remove suffix 1
    $text = preg_replace("|\\</code\\>\$|", "", $text, 1);
    // remove line breaks
    $text = trim($text);
    // remove suffix 2
    $text = preg_replace("|\\</span\\>\$|", "", $text, 1);
    // remove line breaks
    $text = trim($text);
    // remove custom added "<?php "
    $text = preg_replace("|^(\\<span style\\=\"color\\: #[a-fA-F0-9]{0,6}\"\\>)(&lt;\\?php&nbsp;)(.*?)(\\</span\\>)|", "\$1\$3\$4", $text);
  }
  return $text;
}
