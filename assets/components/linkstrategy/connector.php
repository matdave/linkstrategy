<?php
/**
 * LinkStrategy Connector
 *
 * @package linkstrategy
 *
 * @var modX $modx
 */
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
require_once MODX_CONNECTORS_PATH . 'index.php';

$corePath = $modx->getOption('linkstrategy.core_path', null, $modx->getOption('core_path', null, MODX_CORE_PATH) . 'components/linkstrategy/');
/** @var LinkStrategy $linkstrategy */
$linkstrategy = $modx->getService(
    'linkstrategy',
    'LinkStrategy',
    $corePath . 'model/linkstrategy/',
    array(
        'core_path' => $corePath
    )
);

/* handle request */
$path = $modx->getOption('processorsPath', $modx->linkstrategy->config, $corePath . 'processors/');
$modx->request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));
