<?php

namespace LinkStrategy\v2\Elements\Event;

use LinkStrategy\v2\Traits\Resource;

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
        $contentType = $this->modx->getObject('modContentType', $this->resource->get('content_type'));
        if (empty($contentType) ||
            $contentType->get('mime_type') !== 'text/html'
        ) {
            return;
        }
        if ($mode !== \modSystemEvent::MODE_NEW) {
            $this->clearResourceLinks();
        }
        $this->processLinks();
    }
}
