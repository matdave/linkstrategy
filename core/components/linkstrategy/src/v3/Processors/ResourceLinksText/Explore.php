<?php

namespace LinkStrategy\v3\Processors\ResourceLinksText;

use LinkStrategy\v3\Model\Links;
use LinkStrategy\v3\Model\ResourceLinksText;
use MODX\Revolution\modResource;
use MODX\Revolution\Processors\Model\GetListProcessor;
use xPDO\Om\xPDOQuery;

class Explore extends GetListProcessor
{
    use \LinkStrategy\v3\Traits\GetList;
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
