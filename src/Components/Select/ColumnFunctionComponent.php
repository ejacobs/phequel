<?php

namespace Ejacobs\Phequel\Components\Select;

use Ejacobs\Phequel\Format;

class ColumnFunctionComponent extends AbstractColumnComponent
{
    private $function;
    private $column;
    private $alias;
    private $quoted;

    /**
     * ColumnComponentComponent constructor.
     * @param $function
     * @param $column
     * @param $alias
     * @param $quoted
     */
    public function __construct($function, $column = null, $alias = null, $quoted = true)
    {
        $this->function = $function;
        $this->column = $column;
        $this->alias = $alias;
        $this->quoted = $quoted;
    }
    /**
     * @return string
     */
    public function __toString() {
        return $this->compose(true, [
            [Format::type_function, [$this->function, $this->column], Format::spacing_default, $this->quoted],
            [Format::type_function_unquoted, [$this->function, $this->column], Format::spacing_default, !$this->quoted],
            [Format::type_alias, $this->alias],
        ]);
    }

}
