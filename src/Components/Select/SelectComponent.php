<?php

namespace Ejacobs\Phequel\Components\Select;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Format;

class SelectComponent extends AbstractExpression
{

    private $columns = [];
    private $defaultSelectAll = false;
    private $distinct = false;
    private $distinctOn = null;

    /**
     * Select all columns (*) by default, unless explicitly specified
     *
     * SelectComponent constructor.
     */
    public function __construct()
    {
        $this->addColumn(new ColumnRawComponent('*'));
        $this->defaultSelectAll = true;
    }

    /**
     * @param AbstractColumnComponent $column
     */
    public function addColumn(AbstractColumnComponent $column)
    {
        if ($this->defaultSelectAll) {
            $this->columns = [];
            $this->defaultSelectAll = false;
        }
        $this->columns[] = $column;
    }

    /**
     * @return $this
     */
    public function clearColumns()
    {
        $this->columns = [];
        return $this;
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
        return $this->compose(true, [
            [Format::type_block_keyword, 'select'],
            [Format::type_comma_separated, $this->columns, Format::spacing_no_space],
            [Format::type_block_end]
        ]);
    }

}
