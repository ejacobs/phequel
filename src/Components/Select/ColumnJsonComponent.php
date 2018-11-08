<?php

namespace Phion\Phequel\Components\Select;

use Phion\Phequel\Format;

class ColumnJsonComponent extends AbstractColumnComponent
{

    private $column;
    private $selector;
    private $jsonOperator;
    private $alias;

    /**
     * ColumnJsonComponent constructor.
     * @param $column
     * @param $selector
     * @param string $jsonOperator
     * @param null $alias
     */
    public function __construct($column, $selector, $jsonOperator = '->>', $alias = null)
    {
        $this->column = $column;
        $this->selector = $selector;
        $this->jsonOperator = $jsonOperator;
        $this->alias = $alias;
    }

    /**
     * @return string
     */
    public function toString() {

        return $this->compose(true, [
            [Format::type_column, $this->column, Format::spacing_default],
            [Format::type_column_json, [$this->selector, $this->jsonOperator]],
            [Format::type_alias, $this->alias],
        ]);
    }

}
