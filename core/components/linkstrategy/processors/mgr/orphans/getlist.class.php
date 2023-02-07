<?php
require_once dirname(__FILE__, 4) . '/model/vendor/autoload.php';
class OrphansGetListProcessor extends modObjectGetListProcessor
{
    use \LinkStrategy\Traits\GetList;
    public $classKey = 'modResource';
    public $alias = 'modResource';
    public $languageTopics = ['linkstrategy:default'];
    public $defaultSortField = 'id';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'modx.resource';
    public $leftJoin = ['Links' => ['compare' => '`modResource`.`id` = `Links`.`resource`', 'alias' => 'Links']];
    public $dynamicFilter = [
        'query'=>['pagetitle:LIKE','OR:longtitle:LIKE','OR:content:LIKE'],
        'deleted'=>['deleted'],
        'published'=>['published'],
        'context'=>['context_key'],
    ];

    public function prepareCustomProcessing(\xPDOQuery $c): \xPDOQuery
    {
        $c->where(['Links.id:IS' => null]);
        return $c;
    }
}

return 'OrphansGetListProcessor';