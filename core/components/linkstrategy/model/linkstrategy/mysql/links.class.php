<?php
/**
 * @package linkstrategy
 */
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/links.class.php');
class Links_mysql extends Links {}
?>