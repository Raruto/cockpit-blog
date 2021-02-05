<?php
 return array (
  'name' => 'pages',
  'label' => 'Pages',
  '_id' => 'pages',
  'fields' => 
  array (
    0 => 
    array (
      'name' => 'published',
      'label' => 'Published',
      'type' => 'boolean',
      'default' => '',
      'info' => '',
      'localize' => false,
      'options' => 
      array (
        'default' => false,
        'label' => false,
      ),
      'width' => '1-1',
      'lst' => true,
      'group' => 'Attributes',
    ),
    1 => 
    array (
      'name' => 'title',
      'label' => 'Title',
      'type' => 'text',
      'default' => '',
      'info' => '',
      'localize' => false,
      'options' => 
      array (
        'slug' => true,
      ),
      'width' => '1-1',
      'lst' => true,
      'required' => true,
    ),
    2 => 
    array (
      'name' => 'slug',
      'label' => '',
      'type' => 'slug',
      'default' => '',
      'info' => '',
      'group' => '',
      'localize' => false,
      'options' => 
      array (
        'format' => '[field:title]',
      ),
      'width' => '1-1',
      'lst' => true,
      'acl' => 
      array (
      ),
    ),
    3 => 
    array (
      'name' => 'image',
      'label' => 'Featured Image',
      'type' => 'asset',
      'default' => '',
      'info' => '',
      'localize' => false,
      'options' => 
      array (
      ),
      'width' => '1-1',
      'lst' => true,
    ),
    4 => 
    array (
      'name' => 'content',
      'label' => 'Content',
      'type' => 'html',
      'default' => '',
      'info' => '',
      'localize' => false,
      'options' => 
      array (
        'enablescripts' => true,
      ),
      'width' => '1-1',
      'lst' => true,
    ),
    5 => 
    array (
      'name' => 'excerpt',
      'label' => 'Excerpt',
      'type' => 'markdown',
      'default' => '',
      'info' => '',
      'localize' => false,
      'options' => 
      array (
      ),
      'width' => '1-1',
      'lst' => true,
    ),
    6 => 
    array (
      'name' => 'keyword',
      'label' => '',
      'type' => 'text',
      'default' => '',
      'info' => '',
      'group' => '',
      'localize' => false,
      'options' => 
      array (
      ),
      'width' => '1-1',
      'lst' => true,
      'acl' => 
      array (
      ),
    ),
    7 => 
    array (
      'name' => 'tags',
      'label' => 'Tags',
      'type' => 'tags',
      'default' => '',
      'info' => '',
      'localize' => false,
      'options' => 
      array (
      ),
      'width' => '1-1',
      'lst' => true,
    ),
    8 => 
    array (
      'name' => 'show_title',
      'label' => '',
      'type' => 'boolean',
      'default' => '',
      'info' => '',
      'group' => 'Attributes',
      'localize' => false,
      'options' => 
      array (
        'default' => true,
      ),
      'width' => '1-1',
      'lst' => true,
      'acl' => 
      array (
      ),
    ),
  ),
  'sortable' => false,
  'in_menu' => false,
  '_created' => 1609110417,
  '_modified' => 1612448565,
  'color' => '',
  'acl' => 
  array (
  ),
  'sort' => 
  array (
    'column' => '_created',
    'dir' => -1,
  ),
  'rules' => 
  array (
    'create' => 
    array (
      'enabled' => false,
    ),
    'read' => 
    array (
      'enabled' => false,
    ),
    'update' => 
    array (
      'enabled' => false,
    ),
    'delete' => 
    array (
      'enabled' => false,
    ),
  ),
  'icon' => '',
  'has_sitemap' => true,
  'has_feed' => true,
  'base_slug' => '/',
);