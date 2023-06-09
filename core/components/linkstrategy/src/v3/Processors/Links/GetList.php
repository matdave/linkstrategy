<?php

namespace LinkStrategy\v3\Processors\Links;

use LinkStrategy\v3\Model\Links;
use LinkStrategy\v3\Model\ResourceLinksText;
use MODX\Revolution\modResource;
use MODX\Revolution\Processors\Model\GetListProcessor;
use xPDO\Om\xPDOQuery;

class GetList extends GetListProcessor
{
    use \LinkStrategy\v3\Traits\GetList;
    public $classKey = Links::class;
    public $alias = 'Links';
    public $languageTopics = ['linkstrategy:default'];
    public $defaultSortField = 'resourcelinks_count';
    public $defaultSortDirection = 'DESC';
    public $objectType = 'linkstrategy.links';
    public $leftJoin = [
        modResource::class => 'Resource',
        ResourceLinksText::class => 'ResourceLinksText',
        'ResourceLinksTextResource' => [
            'compare' => '`ResourceLinksText`.`resource` = `ResourceLinksTextResource`.`id`',
            'alias' => 'ResourceLinksTextResource',
            'class' => modResource::class,
        ]
    ];
    public $dynamicFilter = [
        'query'=>['url:LIKE','OR:uri:LIKE'],
        'resource' => 'resource',
        'internal' => 'internal',
        'context' => 'ResourceLinksTextResource.context_key',
    ];

    public function prepareCustomProcessing(xPDOQuery $c): xPDOQuery
    {
        $c->select(['textvariants_count' =>'COUNT(DISTINCT(ResourceLinksText.text))']);
        $c->select(['resourcelinks_count' =>'COUNT(DISTINCT(ResourceLinksText.resource))']);
        $c->groupBy('Links.id');
        return $c;
    }
}
