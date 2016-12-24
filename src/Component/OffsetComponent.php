<?php

namespace Ejacobs\QueryBuilder\Component;


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
