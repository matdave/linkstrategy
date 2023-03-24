<?php
namespace LinkStrategy\v3\Model;

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
 * @property \LinkStrategy\v3\Model\ResourceLinks[] $ResourceLinks
 * @property \LinkStrategy\v3\Model\ResourceLinksText[] $ResourceLinksText
 *
 * @package LinkStrategy\v3\Model
 */
class Links extends \xPDO\Om\xPDOSimpleObject
{
}
