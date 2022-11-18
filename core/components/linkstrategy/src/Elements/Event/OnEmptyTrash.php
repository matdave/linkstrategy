<?php

namespace LinkStrategy\Elements\Event;

use LinkStrategy\Model\ResourceLinks;

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
