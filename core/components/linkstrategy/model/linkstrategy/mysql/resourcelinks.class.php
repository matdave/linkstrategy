<?php
/**
 * @package linkstrategy
 */
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/resourcelinks.class.php');
class ResourceLinks_mysql extends ResourceLinks {}
?>