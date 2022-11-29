<?php

namespace LinkStrategy\Processors\ResourceLinksText;

use LinkStrategy\Model\Links;
use MODX\Revolution\Processors\Model\GetListProcessor;
use MODX\Revolution\modResource;
use LinkStrategy\Model\ResourceLinksText;
use xPDO\Om\xPDOQuery;

class Explore extends GetListProcessor
{
    use \LinkStrategy\Traits\GetList;
    public $classKey = ResourceLinksText::class;
    public $alias = 'ResourceLinksText';
    public $languageTopics = ['linkstrategy:default'];
    public $defaultSortField = 'Link.uri';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'linkstrategy.linksexplorer';
    public $leftJoin = [Links::class => 'Link', modResource::class => 'Resource'];
    public $dynamicFilter = [
        'query'=>['Link.url:LIKE', 'OR:Link.uri:LIKE'],
        'text' => 'ResourceLinksText.text',
        'link' => 'ResourceLinksText.link',
    ];
}
