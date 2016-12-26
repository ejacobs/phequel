<?php

namespace Ejacobs\QueryBuilder\Component;


class InsertRowComponent extends AbstractComponent
{
    private $data;

    /**
     * InsertRowComponent constructor.
     * @param array $columns
     * @param array $data
     */
    public function __construct(array $columns, array $data)
    {
        foreach ($columns as $column) {
            if (isset($data[$column])) {
                $this->data[$column] = $data[$column];
            }
            else {
                $this->data[$column] = null;
            }
        }
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array_values(($this->data));
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $params = array_fill(0, count($this->data), '?');
        return '(' . implode(', ', $params) . ')';
    }

}
