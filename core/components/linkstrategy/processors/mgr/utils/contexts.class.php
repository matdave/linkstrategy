<?php
require_once dirname(__FILE__, 4) . '/model/vendor/autoload.php';

class UtilsContextsProcessor extends modObjectGetListProcessor
{
    use \LinkStrategy\Traits\GetList;
    public $classKey = 'modContext';
    public $alias = 'modContext';
    public $languageTopics = ['linkstrategy:default'];
    public $defaultSortField = 'modContext.key';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'context';
    public $dynamicFilter = [
        'query'=>['modContext.key:LIKE', 'OR:modContext.name:LIKE']
    ];

    public function prepareCustomProcessing(\xPDOQuery $c): \xPDOQuery
    {
        $c->where(['modContext.key:NOT IN' => ['mgr']]);
        return $c;
    }
}

return 'UtilsContextsProcessor';