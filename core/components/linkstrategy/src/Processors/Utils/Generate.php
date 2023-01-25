<?php

namespace LinkStrategy\Processors\Utils;

use LinkStrategy\Traits\Resource;
use MODX\Revolution\modContentType;
use MODX\Revolution\modResource;
use MODX\Revolution\Processors\ModelProcessor;
use xPDO\xPDO;

class Generate extends ModelProcessor
{
    use Resource;

    public $languageTopics = ['linkstrategy:default'];
    public $objectType = 'linkstrategy.generate';

    public function process()
    {
        $count = $this->generate();
        return $this->success($this->modx->lexicon('linkstrategy.generate.complete', ['count' => $count]));
    }

    public function generate()
    {
        $c = $this->modx->newQuery(modResource::class);
        $c->leftJoin(modContentType::class, 'ContentType');
        $c->where(['ContentType.mime_type' => 'text/html']);
        $collection = $this->modx->getCollection(modResource::class, $c);
        $count = $this->modx->getCount(modResource::class, $c);
        foreach ($collection as $resource) {
            $this->resource = $resource;
            $this->object = $resource;
            $this->clearResourceLinks();
            $this->processLinks();
            $this->modx->log(
                xPDO::LOG_LEVEL_INFO,
                $this->modx->lexicon('linkstrategy.generate.status', [
                    'id' => $this->resource->id,
                    'pagetitle' => $this->resource->pagetitle,
                ])
            );
        }
        return $count;
    }
}
