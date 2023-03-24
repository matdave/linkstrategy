<?php

namespace LinkStrategy\v3\Processors\Utils;

use LinkStrategy\v3\Model\ResourceLinksText;
use MODX\Revolution\Processors\Model\GetListProcessor;
use xPDO\Om\xPDOQuery;

class Text extends GetListProcessor
{
    use \LinkStrategy\v3\Traits\GetList;
    public $classKey = ResourceLinksText::class;
    public $alias = 'ResourceLinksText';
    public $languageTopics = ['linkstrategy:default'];
    public $defaultSortField = 'text';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'linkstrategy.resourcelinkstext';
    public $dynamicFilter = [
        'text' => 'text:LIKE',
    ];
    public $staticFilter = ['link'];

    public function prepareCustomProcessing(xPDOQuery $c): xPDOQuery
    {
        $c->groupBy('text');
        return $c;
    }
}
