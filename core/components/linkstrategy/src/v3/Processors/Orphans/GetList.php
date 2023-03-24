<?php

namespace LinkStrategy\v3\Processors\Orphans;

use LinkStrategy\v3\Model\Links;
use MODX\Revolution\modResource;
use MODX\Revolution\Processors\Model\GetListProcessor;
use xPDO\Om\xPDOQuery;

class GetList extends GetListProcessor
{
    use \LinkStrategy\v3\Traits\GetList;
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
        'context'=>['context_key'],
    ];

    public function prepareCustomProcessing(xPDOQuery $c): xPDOQuery
    {
        $c->where(['Links.id:IS' => null]);
        return $c;
    }
}
