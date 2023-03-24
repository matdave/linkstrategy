<?php
namespace LinkStrategy\v3\Model\mysql;

use xPDO\xPDO;

class ResourceLinks extends \LinkStrategy\v3\Model\ResourceLinks
{

    public static $metaMap = array (
        'package' => 'LinkStrategy\\v3\\Model\\',
        'version' => '3.0',
        'table' => 'ls_resource_links',
        'extends' => 'xPDO\\Om\\xPDOObject',
        'tableMeta' => 
        array (
            'engine' => 'InnoDB',
        ),
        'fields' => 
        array (
            'link' => NULL,
            'resource' => NULL,
        ),
        'fieldMeta' => 
        array (
            'link' => 
            array (
                'dbtype' => 'int',
                'precision' => '11',
                'attributes' => 'unsigned',
                'phptype' => 'integer',
                'null' => false,
            ),
            'resource' => 
            array (
                'dbtype' => 'int',
                'precision' => '11',
                'attributes' => 'unsigned',
                'phptype' => 'integer',
                'null' => false,
            ),
        ),
        'indexes' => 
        array (
            'PRIMARY' => 
            array (
                'alias' => 'PRIMARY',
                'primary' => true,
                'unique' => true,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'link' => 
                    array (
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ),
                    'resource' => 
                    array (
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ),
                ),
            ),
            'link' => 
            array (
                'alias' => 'link',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'link' => 
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
        'aggregates' => 
        array (
            'Link' => 
            array (
                'class' => 'LinkStrategy\\v3\\Model\\Links',
                'local' => 'link',
                'foreign' => 'id',
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
