<?php

namespace Ejacobs\Phequel\Components\Select;

use Ejacobs\Phequel\Components\AbstractComponent;

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

    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->columns) {
            return $this->formatter()->insertKeyword(' group by ') . implode(', ', $this->columns);
        }
        return '';
    }

}
