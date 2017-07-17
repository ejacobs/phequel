<?php

namespace Ejacobs\Phequel\Components;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Format;

class ColumnComponent extends AbstractExpression
{
    /* @var string|null $column */
    private $column;

    /**
     * ColumnComponent constructor.
     * @param null|string $column
     */
    public function __construct($column = null)
    {
        $this->column = $column;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->compose(!!$this->column, [
            [Format::type_columns, $this->column]
        ]);
    }

}
