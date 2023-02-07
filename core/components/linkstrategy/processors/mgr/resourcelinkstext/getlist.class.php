<?php
require_once dirname(__FILE__, 4) . '/model/vendor/autoload.php';
class ResourceLinksTextGetListProcessor extends modObjectGetListProcessor
{
    use \LinkStrategy\Traits\GetList;
    public $classKey = 'ResourceLinksText';
    public $alias = 'ResourceLinksText';
    public $languageTopics = ['linkstrategy:default'];
    public $defaultSortField = 'text';
    public $defaultSortDirection = 'DESC';
    public $objectType = 'linkstrategy.resourcelinkstext';
    public $leftJoin = ['modResource' => 'Resource'];
    public $dynamicFilter = [
        'query'=>['text:LIKE'],
        'link' => 'link',
        'context' => 'Resource.context_key',
    ];

    public function prepareCustomProcessing(\xPDOQuery $c): \xPDOQuery
    {
        $c->select(['link_count' =>'COUNT(DISTINCT(ResourceLinksText.link))']);
        $c->select(['resource_count' =>'COUNT(ResourceLinksText.resource)']);
        $c->groupBy('ResourceLinksText.text');
        return $c;
    }
}

return 'ResourceLinksTextGetListProcessor';