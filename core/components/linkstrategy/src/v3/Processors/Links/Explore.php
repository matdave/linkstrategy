<?php

namespace LinkStrategy\v3\Processors\Links;

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
    public $defaultSortField = 'ResourceLinksText.text';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'linkstrategy.linksexplorer';
    public $leftJoin = [modResource::class => 'Resource'];
    public $dynamicFilter = [
        'query'=>['text:LIKE', 'OR:Resource.pagetitle:LIKE', 'OR:Resource.longtitle:LIKE', 'OR:Resource.menutitle:LIKE'],
        'link' => 'ResourceLinksText.link',
        'text' => 'ResourceLinksText.text',
    ];
}
