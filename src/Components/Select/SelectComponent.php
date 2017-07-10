<?php

namespace Ejacobs\Phequel\Components\Select;

use Ejacobs\Phequel\Components\AbstractComponent;
use Ejacobs\Phequel\Components\ColumnComponent;
use Ejacobs\Phequel\Formatter;

class SelectComponent extends AbstractComponent
{
    private $columns = [];
    private $defaultSelectAll = false;
    private $distinct = false;
    private $distinctOn = null;

    /**
     * Select all columns (*) by default, unless explicitly specified
     *
     * SelectComponent constructor.
     * @param string $columns
     */
    public function __construct($columns = '*')
    {
        $this->addColumns($columns);
        if ($columns === '*') {
            $this->defaultSelectAll = true;
        }
    }

    /**
     * @param array|string $columns
     * @param bool $clear
     */
    public function addColumns($columns, $clear = false)
    {
        if ($this->defaultSelectAll || $clear) {
            $this->columns = [];
            $this->defaultSelectAll = false;
        }
        if (!is_array($columns)) {
            $columns = [$columns];
        }
        foreach ($columns as $column) {
            $this->columns[] = $column;
        }
    }

    /**
     * @param bool $distinct
     * @param null $on
     */
    public function setDistinct($distinct = true, $on = null)
    {
        $this->distinct = $distinct;
        $this->distinctOn = $on;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $formatter = $this->formatter();
        return $formatter->insert($formatter::type_block_keyword, 'select')
            . $formatter->insert($formatter::type_columns, $this->columns)
            . $formatter->insert($formatter::type_end);
    }

}
