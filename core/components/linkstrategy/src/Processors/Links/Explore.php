<?php

namespace LinkStrategy\Processors\Links;

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
    public $defaultSortField = 'ResourceLinksText.text';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'linkstrategy.linksexplorer';
    public $leftJoin = [modResource::class => 'Resource'];
    public $dynamicFilter = [
        'query'=>['text:LIKE', 'OR:Resource.pagetitle:LIKE', 'OR:Resource.longtitle:LIKE', 'OR:Resource.menutitle:LIKE'],
        'link' => 'ResourceLinksText.link',
    ];
}
