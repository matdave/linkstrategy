<?php

namespace LinkStrategy\Elements\Event;

use LinkStrategy\Traits\Resource;
use MODX\Revolution\modResource;
use LinkStrategy\Model\ResourceLinks;

class OnDocFormSave extends Event
{
    use Resource;

    public function run()
    {
        $mode = $this->getOption('mode');
        $this->resource = $this->getOption('resource');
        if (empty($this->resource)) {
            return;
        }
        if ($mode !== 'new') {
            $this->clearResourceLinks();
        }
        $this->processLinks();
    }

    public function clearResourceLinks(): void
    {
        $this->modx->removeCollection(ResourceLinks::class, [
            'resource' => $this->resource->id
        ]);
    }
}
