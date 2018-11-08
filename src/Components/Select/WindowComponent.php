<?php

namespace Phion\Phequel\Components\Select;

use Phion\Phequel\AbstractExpression;
use Phion\Phequel\Format;

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
    public function toString()
    {
        $components = [];
        foreach ($this->windows as $window) {
            $components[] = $this->compose(true, [
                [Format::type_indentation],
                [Format::type_table, $window[0], Format::spacing_no_space],
                [Format::type_keyword, 'as', Format::spacing_no_indent],
                [Format::type_open_paren, null, Format::spacing_no_indent],
                [Format::type_indentation, null, Format::spacing_no_indent],
                [Format::type_keyword, 'partition by'],
                [Format::type_indentation],
                [Format::type_comma_separated, $window[1], Format::spacing_no_indent],
                [Format::type_block_end],
                new OrderByComponent($window[2]),
                [Format::type_block_end],
                [Format::type_close_paren],
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
