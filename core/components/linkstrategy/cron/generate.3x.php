<?php

$tStart = microtime(true);

define('MODX_API_MODE', true);
@include(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/config.core.php');

if (!@require_once(MODX_CORE_PATH . "vendor/autoload.php")) {
    exit();
}

ob_start();

$modx = new \MODX\Revolution\modX();
if (!is_object($modx) || !($modx instanceof \MODX\Revolution\modX)) {
    ob_get_level() && @ob_end_flush();
    exit();
}

$modx->startTime = $tStart;
$modx->initialize('web');
return $modx->runProcessor(\LinkStrategy\v3\Processors\Utils\Generate::class, []);
