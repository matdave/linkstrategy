<?php

namespace LinkStrategy\v3\Processors\Utils;

use LinkStrategy\v3\Model\Links as LinksClass;
use LinkStrategy\v3\Model\ResourceLinksText;
use MODX\Revolution\Processors\Model\GetListProcessor;
use xPDO\Om\xPDOQuery;

class Links extends GetListProcessor
{
    use \LinkStrategy\v3\Traits\GetList;
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
