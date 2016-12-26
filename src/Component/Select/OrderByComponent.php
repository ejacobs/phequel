<?php

namespace Ejacobs\QueryBuilder\Component\Select;

use Ejacobs\QueryBuilder\Component\AbstractComponent;

class OrderByComponent extends AbstractComponent
{
    private $column;
    private $direction;

    /**
     * OffsetComponent constructor.
     * @param $column
     * @param string $direction
     */
    public function __construct($column = null, $direction = 'ASC')
    {
        $this->column = $column;
        $this->direction = $direction;
    }

    public function __toString()
    {
        if ($this->column) {
            return " ORDER BY {$this->column} {$this->direction}";
        }
        else {
            return '';
        }
    }

}
