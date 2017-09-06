<?php

namespace Ejacobs\Phequel\Components\Select;

use Ejacobs\Phequel\Format;

class ColumnComponent extends AbstractColumnComponent
{
    private $column;
    private $alias;
    private $quoted;

    /**
     * ColumnComponentComponent constructor.
     * @param $column
     * @param $alias
     * @param $quoted
     */
    public function __construct($column, $alias = null, $quoted = true)
    {
        $this->column = $column;
        $this->alias = $alias;
        $this->quoted = $quoted;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->compose(true, [
            [Format::type_column, $this->column],
            [Format::type_alias, $this->alias]
        ]);
    }

}
