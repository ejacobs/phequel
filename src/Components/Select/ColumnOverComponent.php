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
    public function toString()
    {
        return $this->compose(true, [
            new ColumnFunctionComponent($this->function, $this->column),
            [Format::type_keyword, 'over', Format::spacing_no_indent],
            [Format::type_open_paren, null, Format::spacing_no_indent],
            [Format::type_indentation, null, Format::spacing_no_indent],
            [Format::type_keyword, 'partition by'],
            [Format::type_indentation],
            [Format::type_comma_separated, $this->column, Format::spacing_no_indent],
            [Format::type_block_end],
            new OrderByComponent($this->orderBy),
            [Format::type_block_end],
            [Format::type_close_paren],
        ]);
    }

}
