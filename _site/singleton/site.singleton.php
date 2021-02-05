<?php
 return array (
  'name' => 'site',
  'label' => 'Site',
  '_id' => 'site',
  'fields' => 
  array (
    0 => 
    array (
      'name' => 'menu',
      'label' => '',
      'type' => 'repeater',
      'default' => '',
      'info' => '',
      'group' => '',
      'localize' => false,
      'options' => 
      array (
        'field' => 
        array (
          'type' => 'set',
          'label' => 'navigation',
          'options' => 
          array (
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'title',
                'type' => 'text',
              ),
              1 => 
              array (
                'name' => 'url',
                'type' => 'text',
              ),
            ),
          ),
        ),
      ),
      'width' => '1-1',
      'lst' => true,
      'acl' => 
      array (
      ),
    ),
  ),
  'data' => NULL,
  '_created' => 1610201263,
  '_modified' => 1612520820,
  'description' => '',
  'acl' => 
  array (
  ),
  'icon' => '',
);