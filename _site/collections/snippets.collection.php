<?php
 return array (
  'name' => 'snippets',
  'label' => 'Snippets',
  '_id' => 'snippets',
  'fields' => 
  array (
    0 => 
    array (
      'name' => 'id',
      'label' => '',
      'type' => 'slug',
      'default' => '',
      'info' => '',
      'group' => '',
      'localize' => false,
      'options' => 
      array (
        'format' => '[field:_id]',
      ),
      'width' => '1-1',
      'lst' => true,
      'acl' => 
      array (
      ),
      'required' => true,
    ),
    1 => 
    array (
      'name' => 'code',
      'label' => '',
      'type' => 'code',
      'default' => '',
      'info' => '',
      'group' => '',
      'localize' => false,
      'options' => 
      array (
        'syntax' => 'php',
        'height' => 'auto',
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
  '_created' => 1612434126,
  '_modified' => 1612447910,
  'color' => '#3C3B3D',
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
  'icon' => 'code.svg',
);