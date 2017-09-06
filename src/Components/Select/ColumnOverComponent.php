<?php

namespace Ejacobs\Phequel\Components\Select;

use Ejacobs\Phequel\Format;

class ColumnOverComponent extends AbstractColumnComponent
{
    private $function;
    private $column;
    private $partitionByColumns;
    private $orderBy;

    /**
     * ColumnOverComponent constructor.
     * @param $function
     * @param $column
     * @param $partitionByColumns
     * @param $orderBy
     */
    public function __construct($function, $column, $partitionByColumns, $orderBy = [])
    {
        $this->function = $function;
        $this->column = $column;
        $this->partitionByColumns = $partitionByColumns;
        $this->orderBy = $orderBy;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->compose(true, [
            [Format::type_function, [$this->function, $this->column]],
            [Format::type_keyword, 'partition by', false, false],
            [Format::type_open_paren, null, true],
            [Format::type_indentation],
            [Format::type_columns, $this->column],
            [Format::type_block_end],
            new OrderByComponent($this->orderBy),
            [Format::type_close_paren, null, true]
        ]);
    }

}
