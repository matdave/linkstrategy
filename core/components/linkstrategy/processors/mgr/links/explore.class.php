<?php
require_once dirname(__FILE__, 4) . '/model/vendor/autoload.php';
class LinksExploreProcessor extends modObjectGetListProcessor
{
    use \LinkStrategy\Traits\GetList;
    public $classKey = 'ResourceLinksText';
    public $alias = 'ResourceLinksText';
    public $languageTopics = ['linkstrategy:default'];
    public $defaultSortField = 'ResourceLinksText.text';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'linkstrategy.linksexplorer';
    public $leftJoin = ['modResource' => 'Resource'];
    public $dynamicFilter = [
        'query'=>['text:LIKE', 'OR:Resource.pagetitle:LIKE', 'OR:Resource.longtitle:LIKE', 'OR:Resource.menutitle:LIKE'],
        'link' => 'ResourceLinksText.link',
        'text' => 'ResourceLinksText.text',
    ];
}

return 'LinksExploreProcessor';
