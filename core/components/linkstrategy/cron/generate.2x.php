<?php

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

$corePath = $modx->getOption('linkstrategy.core_path', null, $modx->getOption('core_path', null, MODX_CORE_PATH) . 'components/linkstrategy/');
$ls = $modx->getService(
    'linkstrategy',
    'LinkStrategy',
    $corePath . 'model/linkstrategy/',
    array(
        'core_path' => $corePath
    )
);
return $modx->runProcessor('mgr/utils/generate', array(), array('processors_path' => $ls->config['processorsPath']));
