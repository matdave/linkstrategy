<?php
namespace LinkStrategy\Model;

use xPDO\xPDO;

/**
 * Class Links
 *
 * @property string $context_key
 * @property boolean $internal
 * @property string $url
 * @property string $uri
 * @property integer $resource
 *
 * @property \LinkStrategy\Model\ResourceLinks[] $Links
 *
 * @package LinkStrategy\Model
 */
class Links extends \xPDO\Om\xPDOSimpleObject
{
}
