<?php
/**
 * @var MODX\Revolution\modX $modx
 * @var array $scriptProperties
 *
 */
$version = 'v2';
if ($modx->version['version'] > 3) {
    $version = 'v3';
    $ls = $modx->services->get('linkstrategy');
} else {
    $corePath = $modx->getOption('linkstrategy.core_path', null, $modx->getOption('core_path', null, MODX_CORE_PATH) . 'components/linkstrategy/');
    $ls = $modx->getService(
        'linkstrategy',
        'LinkStrategy',
        $corePath . 'model/linkstrategy/',
        array(
            'core_path' => $corePath
        )
    );
}

$className = "\\LinkStrategy\\$version\\Elements\\Event\\{$modx->event->name}";

if (class_exists($className)) {
    /** @var $event */
    $event = new $className($ls, $scriptProperties);
    $event->run();
} else {
    $modx->log(\xPDO::LOG_LEVEL_ERROR, "Class {$className} not found");
}