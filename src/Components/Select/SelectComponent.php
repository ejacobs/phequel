<?php

namespace Ejacobs\Phequel\Components\Select;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Format;

class SelectComponent extends AbstractExpression
{
    private $columns = [];
    private $defaultSelectAll = false;
    private $distinct = false;
    private $distinctOn = null;

    /**
     * Select all columns (*) by default, unless explicitly specified
     *
     * SelectComponent constructor.
     * @param array $columns
     */
    public function __construct($columns = ['*'])
    {
        $this->addColumns($columns);
        if ($columns === ['*']) {
            $this->defaultSelectAll = true;
        }
    }

    /**
     * @param array $columns
     */
    public function addColumns($columns)
    {
        if ($this->defaultSelectAll) {
            $this->columns = [];
            $this->defaultSelectAll = false;
        }
        if ($this->isAssociative($columns)) {
            foreach ($columns as $column => $alias) {
                if (is_array($column)) {
                    $this->columns[] = $column;
                }
                else {
                    $this->columns[] = [null, $column, $alias];
                }
            }
        }
        else {
            foreach ($columns as $column) {
                if (is_array($column)) {
                    $this->columns[] = $column;
                }
                else {
                    $this->columns[] = [null, $column];
                }
            }
        }
    }

    /**
     * @return $this
     */
    public function clearColumns()
    {
        $this->columns = [];
        return $this;
    }

    /**
     * @param bool $distinct
     * @param null $on
     */
    public function setDistinct($distinct = true, $on = null)
    {
        $this->distinct = $distinct;
        $this->distinctOn = $on;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->compose(true, [
            [Format::type_block_keyword, 'select'],
            [Format::type_columns, $this->columns],
            [Format::type_block_end]
        ]);
    }

    private function isAssociative(array $arr)
    {
        if ($arr === []) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

}
