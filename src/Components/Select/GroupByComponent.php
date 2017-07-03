<?php

namespace Ejacobs\Phequel\Component\Select;

use Ejacobs\Phequel\Component\AbstractComponent;

class GroupByComponent extends AbstractComponent
{
    private $columns = [];

    /**
     * GroupByComponent constructor.
     * @param $columns
     */
    public function __construct($columns = [])
    {
        $this->addColumns($columns);
    }

    /**
     * @param $columns
     */
    public function addColumns($columns)
    {
        if (!is_array($columns)) {
            $columns = [$columns];
        }
        $this->columns = array_merge($this->columns, $columns);
    }

    public function __toString()
    {
        if ($this->columns) {
            return ' GROUP BY ' . implode(', ', $this->columns);
        }
        return '';
    }

}
