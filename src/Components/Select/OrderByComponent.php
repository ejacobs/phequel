<?php

namespace Ejacobs\Phequel\Components\Select;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Format;

class OrderByComponent extends AbstractExpression
{
    private $column;
    private $direction;

    /**
     * OffsetComponent constructor.
     * @param $column
     * @param string $direction
     */
    public function __construct($column = null, $direction = null)
    {
        $this->column = $column;
        $this->direction = $direction;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $components = [];
        $components[] = [Format::type_block_keyword, 'order by'];
        $components[] = [Format::type_columns, $this->column];
        if ($this->direction !== null) {
            $components[] = [Format::type_keyword, $this->direction];
        }
        $components[] = [Format::type_block_end];
        return $this->compose(!!$this->column, $components);
    }

}
