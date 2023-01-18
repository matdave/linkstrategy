<?php
require_once dirname(__FILE__, 4) . '/model/vendor/autoload.php';
class UtilsTextProcessor extends modObjectGetListProcessor
{
    use \LinkStrategy\Traits\GetList;
    public $classKey = 'ResourceLinksText';
    public $alias = 'ResourceLinksText';
    public $languageTopics = ['linkstrategy:default'];
    public $defaultSortField = 'text';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'linkstrategy.resourcelinkstext';
    public $dynamicFilter = [
        'text' => 'text:LIKE',
    ];
    public $staticFilter = ['link'];

    public function prepareCustomProcessing(\xPDOQuery $c): \xPDOQuery
    {
        $c->groupBy('text');
        return $c;
    }
}

return 'UtilsTextProcessor';