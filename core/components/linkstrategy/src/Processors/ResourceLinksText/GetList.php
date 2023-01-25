<?php

namespace LinkStrategy\Processors\ResourceLinksText;

use LinkStrategy\Model\ResourceLinksText;
use MODX\Revolution\Processors\Model\GetListProcessor;
use xPDO\Om\xPDOQuery;

class GetList extends GetListProcessor
{
    use \LinkStrategy\Traits\GetList;
    public $classKey = ResourceLinksText::class;
    public $alias = 'ResourceLinksText';
    public $languageTopics = ['linkstrategy:default'];
    public $defaultSortField = 'text';
    public $defaultSortDirection = 'DESC';
    public $objectType = 'linkstrategy.resourcelinkstext';
    public $dynamicFilter = [
        'query'=>['text:LIKE'],
        'link' => 'link',
    ];

    public function prepareCustomProcessing(xPDOQuery $c): xPDOQuery
    {
        $c->select(['link_count' =>'COUNT(DISTINCT(ResourceLinksText.link))']);
        $c->select(['resource_count' =>'COUNT(ResourceLinksText.resource)']);
        $c->groupBy('ResourceLinksText.text');
        return $c;
    }
}
