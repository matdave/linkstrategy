<?php

namespace LinkStrategy\Processors\Links;

use LinkStrategy\Model\ResourceLinksText;
use MODX\Revolution\Processors\Model\GetListProcessor;
use MODX\Revolution\modResource;
use LinkStrategy\Model\Links;
use LinkStrategy\Model\ResourceLinks;
use xPDO\Om\xPDOQuery;

class GetList extends GetListProcessor
{
    use \LinkStrategy\Traits\GetList;
    public $classKey = Links::class;
    public $alias = 'Links';
    public $languageTopics = ['linkstrategy:default'];
    public $defaultSortField = 'resourcelinks_count';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'linkstrategy.links';
    public $leftJoin = [modResource::class => 'Resource', ResourceLinksText::class => 'ResourceLinksText'];
    public $dynamicFilter = [
        'query'=>['url:LIKE','OR:uri:LIKE'],
        'resource' => 'resource',
        'internal' => 'internal',
    ];

    public function prepareCustomProcessing(xPDOQuery $c): xPDOQuery
    {
        $c->select(['textvariants_count' =>'COUNT(DISTINCT(ResourceLinksText.text))']);
        $c->select(['resourcelinks_count' =>'COUNT(DISTINCT(ResourceLinksText.resource))']);
        $c->groupBy('Links.id');
        return $c;
    }
}
