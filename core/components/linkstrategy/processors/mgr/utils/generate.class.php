<?php
require_once dirname(__FILE__, 4) . '/model/vendor/autoload.php';
class UtilsGenerateProcessor extends modProcessor
{
    use \LinkStrategy\Traits\Resource;

    public $languageTopics = ['linkstrategy:default'];
    public $objectType = 'linkstrategy.generate';

    public function process()
    {
        $count = $this->generate();
        return $this->success($this->modx->lexicon('linkstrategy.generate.complete', ['count' => $count]));
    }

    public function generate()
    {
        $c = $this->modx->newQuery('modResource');
        $c->where(['contentType' => 'text/html']);
        $collection = $this->modx->getCollection('modResource', $c);
        $count = $this->modx->getCount('modResource', $c);
        foreach ($collection as $resource) {
            $this->resource = $resource;
            $this->object = $resource;
            $this->clearResourceLinks();
            $this->processLinks();
            $this->modx->log(
                \modX::LOG_LEVEL_INFO,
                $this->modx->lexicon('linkstrategy.generate.status', [
                    'id' => $this->resource->id,
                    'pagetitle' => $this->resource->pagetitle,
                ])
            );
        }
        return $count;
    }
}
return 'UtilsGenerateProcessor';