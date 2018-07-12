<?php

namespace Ejacobs\Phequel\Components\Select;

use Ejacobs\Phequel\Format;

class ColumnComponent extends AbstractColumnComponent
{

    private $column;
    private $alias;

    /**
     * ColumnComponentComponent constructor.
     * @param $column
     * @param $alias
     */
    public function __construct($column, $alias = null)
    {
        $this->column = $column;
        $this->alias = $alias;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->compose(true, [
            [Format::type_column, $this->column],
            [Format::type_alias, $this->alias]
        ]);
    }

}
