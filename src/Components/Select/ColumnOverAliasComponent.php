<?php

namespace Ejacobs\Phequel\Components\Select;

use Ejacobs\Phequel\Format;

class ColumnOverAliasComponent extends AbstractColumnComponent
{
    private $function;
    private $column;
    private $alias;

    /**
     * ColumnOverAliasComponent constructor.
     * @param $function
     * @param $column
     * @param $alias
     */
    public function __construct($function, $column, $alias)
    {
        $this->function = $function;
        $this->column = $column;
        $this->alias = $alias;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->compose(true, [
            [Format::type_function, [$this->function, $this->column], false, false],
            [Format::type_keyword, 'over', false, false],
            [Format::type_column, $this->alias, false, false]
        ]);
    }

}