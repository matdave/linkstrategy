<?php

namespace LinkStrategy\Elements\Event;

use LinkStrategy\LinkStrategy;
use MODX\Revolution\modX;

abstract class Event
{
    /**
     * A reference to the modX object.
     * @var modX $modx
     */
    public $modx = null;

    protected LinkStrategy $ls;

    /** @var array */
    protected $sp = [];

    public function __construct(LinkStrategy $ls, array $scriptProperties)
    {
        $this->ls =& $ls;
        $this->modx =& $this->ls->modx;
        $this->sp = $scriptProperties;
    }

    abstract public function run();

    protected function getOption($key, $default = null, $skipEmpty = false)
    {
        return $this->modx->getOption($key, $this->sp, $default, $skipEmpty);
    }
}
