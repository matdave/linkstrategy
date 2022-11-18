<?php
namespace LinkStrategy\Model\mysql;

use xPDO\xPDO;

class Links extends \LinkStrategy\Model\Links
{

    public static $metaMap = array (
        'package' => 'LinkStrategy\\Model\\',
        'version' => '3.0',
        'table' => 'ls_links',
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
            'resource' => NULL,
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
                'index' => 'index',
            ),
            'uri' => 
            array (
                'dbtype' => 'text',
                'phptype' => 'string',
                'null' => true,
                'index' => 'index',
            ),
            'resource' => 
            array (
                'dbtype' => 'int',
                'precision' => '11',
                'attributes' => 'unsigned',
                'phptype' => 'integer',
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
                'class' => 'LinkStrategy\\Model\\ResourceLinks',
                'local' => 'id',
                'foreign' => 'link',
                'cardinality' => 'many',
                'owner' => 'local',
            ),
            'ResourceLinksText' => 
            array (
                'class' => 'LinkStrategy\\Model\\ResourceLinksText',
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
                'class' => 'MODX\\Revolution\\modContext',
                'local' => 'context_key',
                'foreign' => 'key',
                'cardinality' => 'one',
                'owner' => 'foreign',
            ),
            'Resource' => 
            array (
                'class' => 'MODX\\Revolution\\modResource',
                'local' => 'resource',
                'foreign' => 'id',
                'cardinality' => 'one',
                'owner' => 'foreign',
            ),
        ),
    );

}
