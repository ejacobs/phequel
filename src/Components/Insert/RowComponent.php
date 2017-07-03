<?php

namespace Ejacobs\Phequel\Components\Insert;

use Ejacobs\Phequel\Components\AbstractComponent;

class RowComponent extends AbstractComponent
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
        $ret = ' (' . implode(', ', $this->columns) . ") VALUES\n  ";
        $rows = [];
        $rowPlaceholder = '(' . implode(', ', array_fill(0, count($this->columns), '?')) . ')';
        foreach ($this->rows as $row) {
            $rows[] = $rowPlaceholder;
        }
        $ret .= implode(",\n  ", $rows);
        return $ret;
    }

}
