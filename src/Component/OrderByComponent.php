<?php

namespace Ejacobs\QueryBuilder\Component;


class OrderByComponent extends AbstractComponent
{
    private $column;
    private $direction;

    /**
     * OffsetComponent constructor.
     * @param $column
     * @param string $direction
     */
    public function __construct($column, $direction = 'ASC')
    {
        $this->column = $column;
        $this->direction = $direction;
    }

    public function __toString()
    {
        return "ORDER BY {$this->column} {$this->direction} ";
    }

}
