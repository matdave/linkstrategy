<?php
/**
 * @package linkstrategy
 */
$xpdo_meta_map['Links']= array (
  'package' => 'linkstrategy',
  'version' => '0.1',
  'table' => 'ls_links',
  'extends' => 'xPDOSimpleObject',
  'tableMeta' => 
  array (
    'engine' => 'InnoDB',
  ),
  'fields' => 
  array (
    'context_key' => '',
    'internal' => 0,
    'url' => NULL,
    'uri' => NULL,
    'resource' => 0,
  ),
  'fieldMeta' => 
  array (
    'context_key' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
      'index' => 'index',
    ),
    'internal' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'boolean',
      'null' => false,
      'default' => 0,
      'index' => 'index',
    ),
    'url' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
    ),
    'uri' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
    ),
    'resource' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'default' => 0,
      'null' => false,
      'index' => 'index',
    ),
  ),
  'indexes' => 
  array (
    'context_key' => 
    array (
      'alias' => 'context_key',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'context_key' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'internal' => 
    array (
      'alias' => 'internal',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'internal' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'resource' => 
    array (
      'alias' => 'resource',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'resource' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
  ),
  'composites' => 
  array (
    'ResourceLinks' => 
    array (
      'class' => 'ResourceLinks',
      'local' => 'id',
      'foreign' => 'link',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
    'ResourceLinksText' => 
    array (
      'class' => 'ResourceLinksText',
      'local' => 'id',
      'foreign' => 'link',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
  'aggregates' => 
  array (
    'Context' => 
    array (
      'class' => 'modContext',
      'local' => 'context_key',
      'foreign' => 'key',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
    'Resource' => 
    array (
      'class' => 'modResource',
      'local' => 'resource',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);
