<?php

namespace Ejacobs\Phequel\Components\Insert;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Format;

class RowComponent extends AbstractExpression
{
    private $columns = [];
    private $rows;

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
        // TODO, validate rows and append params
        $this->rows[] = $row;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        $params = [];
        foreach ($this->rows as $row) {
            foreach ($this->columns as $column) {
                if (isset($row[$column])) {
                    $params[] = $row[$column];
                }
                else {
                    $params[] = null;
                }
            }
        }
        return $params;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $columns = [];
        foreach ($this->columns as $column) {
            $columns[] = [Format::type_column, $column, false];
        }
        $components = [];
        $components[] = [Format::type_indentation];
        $components[] = [Format::type_comma_separated, $columns, true];
        $components[] = [Format::type_block_end];
        $components[] = [Format::type_block_keyword, 'values'];
        $rows = [];
        foreach ($this->rows as $row) {
            $rows[] = [Format::type_values, $row, true];
        }
        $components[] = [Format::type_comma_separated, $rows, false];
        $components[] = [Format::type_block_end];
        return $this->compose(true, $components);
    }

}
