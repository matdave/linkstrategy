<?php
require_once dirname(__FILE__, 4) . '/model/vendor/autoload.php';
class ResourceLinksTextExploreProcessor extends modObjectGetListProcessor
{
    use \LinkStrategy\Traits\GetList;
    public $classKey = 'ResourceLinksText';
    public $alias = 'ResourceLinksText';
    public $languageTopics = ['linkstrategy:default'];
    public $defaultSortField = 'Link.uri';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'linkstrategy.linksexplorer';
    public $leftJoin = ['Links' => 'Link', 'modResource' => 'Resource'];
    public $dynamicFilter = [
        'query'=>['Link.url:LIKE', 'OR:Link.uri:LIKE'],
        'text' => 'ResourceLinksText.text',
        'link' => 'ResourceLinksText.link',
    ];
}

return 'ResourceLinksTextExploreProcessor';