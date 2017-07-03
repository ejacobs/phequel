<?php

namespace Ejacobs\Phequel\Component\Select;

use Ejacobs\Phequel\Component\AbstractComponent;

class OffsetComponent extends AbstractComponent
{
    private $offset;

    /**
     * SelectComponent constructor.
     * @param int|null $offset
     */
    public function __construct($offset = null)
    {
        $this->offset = $offset;
    }

    public function __toString()
    {
        if ($this->offset !== null) {
            return ' OFFSET ' . $this->offset;
        } else {
            return '';
        }
    }

}