<?php

namespace Ejacobs\Phequel\Components\Select;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Format;

class OrderByComponent extends AbstractExpression
{
    private $orderBy = [];

    /**
     * OrderByComponent constructor.
     * @param array $orderBy
     */
    public function __construct(array $orderBy = [])
    {
        $this->orderBy = $orderBy;
    }

    /**
     * @param $column
     * @param null $direction
     */
    public function addOrderBy($column, $direction = null)
    {
        $this->orderBy[] = [$column, $direction];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $components = [];
        $components[] = [Format::type_block_keyword, 'order by'];
        foreach ($this->orderBy as $orderBy) {
            if (count($orderBy) === 1) {
                $orderBy[] = null;
            }
            $components[] = [Format::type_column, $orderBy[0]];
            if ($direction = $orderBy[1]) {
                $components[] = [Format::type_keyword, $direction, false, false];
            }
        }
        $components[] = [Format::type_block_end];
        return $this->compose(!!$this->orderBy, $components);
    }

}
