<?php

namespace LinkStrategy\v3\Processors\ResourceLinksText;

use LinkStrategy\v3\Model\ResourceLinksText;
use MODX\Revolution\modResource;
use MODX\Revolution\Processors\Model\GetListProcessor;
use xPDO\Om\xPDOQuery;

class GetList extends GetListProcessor
{
    use \LinkStrategy\v3\Traits\GetList;
    public $classKey = ResourceLinksText::class;
    public $alias = 'ResourceLinksText';
    public $languageTopics = ['linkstrategy:default'];
    public $defaultSortField = 'text';
    public $defaultSortDirection = 'DESC';
    public $objectType = 'linkstrategy.resourcelinkstext';
    public $leftJoin = [modResource::class => 'Resource'];
    public $dynamicFilter = [
        'query'=>['text:LIKE'],
        'link' => 'link',
        'context' => 'Resource.context_key',
    ];

    public function prepareCustomProcessing(xPDOQuery $c): xPDOQuery
    {
        $c->select(['link_count' =>'COUNT(DISTINCT(ResourceLinksText.link))']);
        $c->select(['resource_count' =>'COUNT(ResourceLinksText.resource)']);
        $c->groupBy('ResourceLinksText.text');
        return $c;
    }
}
