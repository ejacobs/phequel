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
            new ColumnFunctionComponent($this->function, $this->column),
            [Format::type_keyword, 'over', Format::spacing_no_indent],
            [Format::type_column, $this->alias, Format::spacing_no_indent]
        ]);
    }

}
