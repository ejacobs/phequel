<?php

namespace Ejacobs\QueryBuilder\Component\Select;

use Ejacobs\QueryBuilder\Component\AbstractComponent;

class SelectComponent extends AbstractComponent
{
    private $columns = [];
    private $defaultSelectAll = false;

    /**
     * Select all columns (*) by default, unless explicitly specified
     *
     * SelectComponent constructor.
     * @param string $columns
     */
    public function __construct($columns = '*')
    {
        if ($columns === '*') {
            $this->defaultSelectAll = true;
            $this->columns = ['*'];
        }
    }

    public function addColumns($columns)
    {
        if ($this->defaultSelectAll) {
            $this->columns = [];
            $this->defaultSelectAll = false;
        }
        if (!is_array($columns)) {
            $columns = [$columns];
        }
        $this->columns = array_merge($this->columns, $columns);
        $this->columns = array_unique($this->columns);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return 'SELECT ' . implode(', ', $this->columns);
    }

}
