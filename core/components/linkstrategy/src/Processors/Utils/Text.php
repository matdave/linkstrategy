<?php

namespace LinkStrategy\Processors\Utils;

use LinkStrategy\Model\ResourceLinksText;
use MODX\Revolution\Processors\Model\GetListProcessor;
use xPDO\Om\xPDOQuery;

class Text extends GetListProcessor
{
    use \LinkStrategy\Traits\GetList;
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
