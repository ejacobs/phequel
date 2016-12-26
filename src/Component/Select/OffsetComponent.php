<?php

namespace Ejacobs\QueryBuilder\Component\Select;

use Ejacobs\QueryBuilder\Component\AbstractComponent;

class OffsetComponent extends AbstractComponent
{
    private $offset;

    /**
     * SelectComponent constructor.
     * @param $offset
     */
    public function __construct($offset)
    {
        $this->offset = $offset;
    }

    public function __toString()
    {
        return ' OFFSET ' . $this->offset . ' ';
    }

}
