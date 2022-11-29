<?php

use LinkStrategy\Processors\Utils\Generate;

$tStart= microtime(true);
// Core Path
$coreConfig = dirname(__FILE__, 5) . '/config.core.php';

require_once $coreConfig;
if (!defined('MODX_CORE_PATH')) {
    define('MODX_CORE_PATH', dirname(__FILE__, 5) . '/core/');
}
/* include the modX class */
if (!@include(MODX_CORE_PATH . "model/modx/modx.class.php")) {
    exit();
}

/* start output buffering */
ob_start();

/* Create an instance of the modX class */
$modx= new modX();
if (!is_object($modx) || !($modx instanceof modX)) {
    ob_get_level() && @ob_end_flush();
    exit();
}

$modx->startTime= $tStart;

$modx->initialize('mgr');

$generate = new Generate($modx);
$count = $generate->generate();
echo $count . "\r\n";
