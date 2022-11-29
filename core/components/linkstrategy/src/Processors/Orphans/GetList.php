<?php

namespace LinkStrategy\Processors\Orphans;

use MODX\Revolution\Processors\Model\GetListProcessor;
use MODX\Revolution\modResource;
use LinkStrategy\Model\Links;
use xPDO\Om\xPDOQuery;

class GetList extends GetListProcessor
{
    use \LinkStrategy\Traits\GetList;
    public $classKey = modResource::class;
    public $alias = 'modResource';
    public $languageTopics = ['linkstrategy:default'];
    public $defaultSortField = 'id';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'modx.resource';
    public $leftJoin = [Links::class => ['compare' => '`modResource`.`id` = `Links`.`resource`', 'alias' => 'Links']];
    public $dynamicFilter = [
        'query'=>['pagetitle:LIKE','OR:longtitle:LIKE','OR:content:LIKE'],
        'deleted'=>['deleted'],
        'published'=>['published'],
    ];

    public function prepareCustomProcessing(xPDOQuery $c): xPDOQuery
    {
        $c->where(['Links.id:IS' => null]);
        return $c;
    }
}
