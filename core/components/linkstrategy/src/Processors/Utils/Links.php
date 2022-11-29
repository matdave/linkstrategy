<?php

namespace LinkStrategy\Processors\Utils;

use MODX\Revolution\Processors\Model\GetListProcessor;
use LinkStrategy\Model\ResourceLinksText;
use LinkStrategy\Model\Links as LinksClass;
use xPDO\Om\xPDOQuery;

class Links extends GetListProcessor
{
    use \LinkStrategy\Traits\GetList;
    public $classKey = ResourceLinksText::class;
    public $alias = 'ResourceLinksText';
    public $languageTopics = ['linkstrategy:default'];
    public $defaultSortField = 'Link.uri';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'linkstrategy.linksexplorer';
    public $leftJoin = [LinksClass::class => 'Link'];
    public $dynamicFilter = [
        'query'=>['Link.url:LIKE', 'OR:Link.uri:LIKE'],
        'text' => 'ResourceLinksText.text',
    ];

    public function prepareCustomProcessing(xPDOQuery $c): xPDOQuery
    {
        $c->groupBy('ResourceLinksText.link');
        return $c;
    }
}
