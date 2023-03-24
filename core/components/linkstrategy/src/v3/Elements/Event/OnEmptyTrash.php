<?php

namespace LinkStrategy\v3\Elements\Event;

use LinkStrategy\Elements\Event\ResourceLinksText;
use LinkStrategy\v3\Model\ResourceLinks;

class OnEmptyTrash extends Event
{
    public function run()
    {
        $ids = $this->getOption('ids');
        if (empty($ids) || !is_array($ids)) {
            return;
        }
        $this->modx->removeCollection(ResourceLinks::class, [
            'resource:IN' => $ids
        ]);
        $this->modx->removeCollection(ResourceLinksText::class, [
            'resource:IN' => $ids
        ]);
    }
}
