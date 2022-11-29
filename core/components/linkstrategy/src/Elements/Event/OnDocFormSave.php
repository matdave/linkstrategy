<?php

namespace LinkStrategy\Elements\Event;

use LinkStrategy\Traits\Resource;
use MODX\Revolution\modContentType;
use MODX\Revolution\modResource;
use MODX\Revolution\modSystemEvent;

class OnDocFormSave extends Event
{
    use Resource;

    public function run()
    {
        $mode = $this->getOption('mode');
        $this->resource = $this->getOption('resource');
        $allowRegenerate = $this->ls->getOption('allow_regenerate_onsave');
        if (empty($this->resource) ||
            !$allowRegenerate
        ) {
            return;
        }
        // Only Check on HTML Content Types
        $contentType = $this->modx->getObject(modContentType::class, $this->resource->get('content_type'));
        if (empty($contentType) ||
            $contentType->get('mime_type') !== 'text/html'
        ) {
            return;
        }
        if ($mode !== modSystemEvent::MODE_NEW) {
            $this->clearResourceLinks();
        }
        $this->processLinks();
    }
}
