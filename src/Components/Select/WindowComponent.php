<?php

namespace Ejacobs\Phequel\Components\Select;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Format;

class WindowComponent extends AbstractExpression
{
    private $windows = [];

    /**
     * @param string $alias
     * @param array $columns
     * @param array $orderBy
     */
    public function addWindow($alias, $columns = [], $orderBy = [])
    {
        $this->windows[] = [$alias, $columns, $orderBy];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $components = [];
        foreach ($this->windows as $window) {
            $components[] = $this->compose(true, [
                [Format::type_indentation],
                [Format::type_column, $window[0]],
                [Format::type_keyword, 'as', false, false],
                [Format::type_open_paren, true, true],
                [Format::type_indentation],
                [Format::type_keyword, 'partition by'],
                [Format::type_indentation],
                [Format::type_columns, $window[1]],
                [Format::type_block_end],
                new OrderByComponent($window[2]),
                [Format::type_block_end],
                [Format::type_close_paren, null, true, true],
                [Format::type_block_end],
            ]);
        }

        return $this->compose(!!$components, [
            [Format::type_block_keyword, 'window'],
            implode(', ', $components),
            [Format::type_block_end],
        ]);
    }

}
