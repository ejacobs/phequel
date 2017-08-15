<?php

namespace Ejacobs\Phequel\Components\Select;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Format;

class WindowComponent extends AbstractExpression
{
    private $windows = [];

    /**
     * WindowComponent constructor.
     * @param array $windows
     */
    public function __construct($windows = [])
    {
        $this->windows = $windows;
    }

    /**
     * @param $alias
     * @param $statement
     */
    public function addWindow($alias, $statement)
    {
        $this->windows[$alias] = $statement;
    }

    /**
     * @param string[] $columns
     */
    public function addWindows($columns)
    {
       foreach ($columns as $alias => $statement) {
           $this->addWindow($alias, $statement);
       }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $components = [];
        $components[] = [Format::type_block_keyword, 'window'];
        foreach ($this->windows as $alias => $window) {
            $components[] = [Format::type_columns, $alias];
            $components[] = [Format::type_keyword, 'as'];
            $components[] = [Format::type_table, $window, true];
        }
        $components[] = [Format::type_block_end];
        return $this->compose(!!$this->windows, $components);
    }

}
