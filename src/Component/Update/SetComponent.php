<?php

namespace Ejacobs\QueryBuilder\Component;


class SetComponent extends AbstractComponent
{
    private $column;
    private $value;

    /**
     * OrderByComponent constructor.
     * @param $column
     * @param $value
     */
    public function __construct($column, $value)
    {
        $this->column = $column;
        $this->value = $value;
    }

    public function getParams()
    {
        return [$this->value];
    }

    public function __toString()
    {
        return "{$this->column} = ?";
    }

}
