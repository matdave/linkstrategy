<?php

use LinkStrategy\Elements\Event\Event;
use LinkStrategy\LinkStrategy;
use xPDO\xPDO;

/**
 * @var MODX\Revolution\modX $modx
 * @var array $scriptProperties
 *
 */

$ls = new LinkStrategy($modx, $scriptProperties);

$className = "\\LinkStrategy\\Elements\\Event\\{$modx->event->name}";

if (class_exists($className)) {
    /** @var Event $event */
    $event = new $className($ls, $scriptProperties);
    $event->run();
} else {
    $modx->log(xPDO::LOG_LEVEL_ERROR, "Class {$className} not found");
}
