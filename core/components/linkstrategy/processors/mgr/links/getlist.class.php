<?php
require_once dirname(__FILE__, 4) . '/model/vendor/autoload.php';
class LinksGetListProcessor extends modObjectGetListProcessor
{
    use \LinkStrategy\Traits\GetList;
    public $classKey = 'Links';
    public $alias = 'Links';
    public $languageTopics = ['linkstrategy:default'];
    public $defaultSortField = 'resourcelinks_count';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'linkstrategy.links';
    public $leftJoin = [
        'modResource' => 'Resource',
        'ResourceLinksText' => 'ResourceLinksText',
        'ResourceLinksTextResource' => [
            'compare' => '`ResourceLinksText`.`resource` = `ResourceLinksTextResource`.`id`',
            'alias' => 'ResourceLinksTextResource',
            'class' => 'modResource'
        ]
    ];
    public $dynamicFilter = [
        'query'=>['url:LIKE','OR:uri:LIKE'],
        'resource' => 'resource',
        'internal' => 'internal',
        'context' => 'ResourceLinksTextResource.context_key',
    ];

    public function prepareCustomProcessing(\xPDOQuery $c): \xPDOQuery
    {
        $c->select(['textvariants_count' =>'COUNT(DISTINCT(ResourceLinksText.text))']);
        $c->select(['resourcelinks_count' =>'COUNT(DISTINCT(ResourceLinksText.resource))']);
        $c->groupBy('Links.id');
        return $c;
    }
}

return 'LinksGetListProcessor';