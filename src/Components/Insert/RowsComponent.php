<?php

namespace Ejacobs\Phequel\Components\Insert;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Format;

class RowsComponent extends AbstractExpression
{

    /* @var array $columns */
    private $columns = [];

    /* @var RowComponent[] $rows */
    private $rows;

    /**
     * RowsComponent constructor.
     * @param RowComponent[] $rows
     */
    public function __construct(array $rows = [])
    {
        $this->rows = $rows;
    }

    /**
     * @param $columns
     */
    public function columns($columns)
    {
        $this->columns = $columns;
    }

    /**
     * @param array $row
     */
    public function addRow($row)
    {
        $this->rows[] = new RowComponent($row);
    }

    /**
     * @return array
     */
    public function getParams()
    {
        $this->sortRowValues();
        $params = [];
        foreach ($this->rows as $row) {
            $params = array_merge($params, $row->getParams());
        }
        return $params;
    }

    /**
     * Sort the order of values on all rows to match the order of columns supplied
     */
    private function sortRowValues()
    {
        foreach ($this->rows as $row) {
            $row->sortValues($this->columns);
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $this->sortRowValues();
        $components = [];
        $components[] = [Format::type_indentation, false];
        $components[] = [Format::type_open_paren, null, Format::spacing_no_indent];
        $components[] = [Format::type_indentation, false];
        $components[] = [Format::type_columns, $this->columns];
        $components[] = [Format::type_block_end];
        $components[] = [Format::type_close_paren];
        $components[] = [Format::type_keyword, 'values'];
        $components[] = [Format::type_indentation];
        $components[] = [Format::type_comma_separated, $this->rows];
        $components[] = [Format::type_block_end];
        $components[] = [Format::type_block_end];
        return $this->compose(true, $components);
    }


}
