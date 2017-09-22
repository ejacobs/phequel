<?php

namespace Ejacobs\Phequel\Components\Select;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Format;

class GroupByComponent extends AbstractExpression
{

    private $columns = [];

    /**
     * GroupByComponent constructor.
     * @param $columns
     */
    public function __construct($columns = [])
    {
        $this->addColumns($columns);
    }

    /**
     * @param $columns
     */
    public function addColumns($columns)
    {
        if (!is_array($columns)) {
            $columns = [$columns];
        }
        $this->columns = array_merge($this->columns, $columns);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->compose(!!$this->columns, [
            [Format::type_block_keyword, 'group by'],
            [Format::type_comma_separated, $this->columns],
            [Format::type_block_end]
        ]);
    }

}
