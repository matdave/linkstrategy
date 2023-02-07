<?php

namespace LinkStrategy\Processors\Utils;

use xPDO\Om\xPDOQuery;
use MODX\Revolution\Processors\Model\GetListProcessor;

class Contexts extends GetListProcessor
{
    use \LinkStrategy\Traits\GetList;
    public $classKey = \MODX\Revolution\modContext::class;
    public $alias = 'modContext';
    public $languageTopics = ['linkstrategy:default'];
    public $defaultSortField = 'modContext.key';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'context';
    public $dynamicFilter = [
        'query'=>['modContext.key:LIKE', 'OR:modContext.name:LIKE']
    ];

    public function prepareCustomProcessing(xPDOQuery $c): xPDOQuery
    {
        $c->where(['modContext.key:NOT IN' => ['mgr']]);
        return $c;
    }
}