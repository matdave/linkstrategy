<?php

namespace LinkStrategy\Elements\Event;

class OnEmptyTrash extends Event
{
    public function run()
    {
        $ids = $this->getOption('ids');
        if (empty($ids) || !is_array($ids)) {
            return;
        }
        $this->modx->removeCollection('ResourceLinks', [
            'resource:IN' => $ids
        ]);
        $this->modx->removeCollection('ResourceLinksText', [
            'resource:IN' => $ids
        ]);
    }
}
