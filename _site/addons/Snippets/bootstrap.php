<?php
/**
 * Cockpit snippets addon
 *
 * @author  Raruto
 * @package cockpit-blog
 * @license MIT
 */

$app->on('admin.init', function() {

    if(!cockpit()->module('collections')->exists('snippets')) {

        cockpit()->module('collections')->createCollection('snippets', [
          'name'   => 'snippets',
          'label'  => 'Snippets',
          'fields' => [
              0 => [
                'name'     => 'id',
                'label'    => '',
                'type'     => 'slug',
                'default'  => '',
                'info'     => '',
                'group'    => '',
                'localize' => false,
                'options'  => [
                  'format' => '[field:_id]',
                ],
                'width'    => '1-1',
                'lst'      => true,
                'acl'      => [],
                'required' => true,
                ],
              1 => [
                'name'     => 'code',
                'label'    => '',
                'type'     => 'code',
                'default'  => '',
                'info'     => '',
                'group'    => '',
                'localize' => false,
                'options'  => [
                  'syntax' => 'php',
                  'height' => 'auto',
                ],
                'width'   => '1-1',
                'lst'     => true,
                'acl'     => [],
              ],
            ],
            'sortable'  => false,
            'in_menu'   => false,
            'color'     => '#3C3B3D',
            'acl'       => [],
            'sort'  => [
              'column'  => '_created',
              'dir'     => -1,
            ],
            'rules' => [
              'create' => [ 'enabled' => false, ],
              'read'   => [ 'enabled' => false, ],
              'update' => [ 'enabled' => false, ],
              'delete' => [ 'enabled' => false, ],
            ],
            'icon'  => 'code.svg',
        ]);
    }

});

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
