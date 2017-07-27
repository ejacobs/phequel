<?php

namespace Ejacobs\Phequel\Components\Insert;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Format;

class ReturningComponent extends AbstractExpression
{
    private $column;
    private $alias;

    /**
     * ReturningComponent constructor.
     * @param string|null $column
     * @param string|null $alias
     */
    public function __construct($column = null, $alias = null)
    {
        $this->column = $column;
        $this->alias = $alias;
    }

    public function __toString()
    {
        $components = [];
        $components[] = [Format::type_block_keyword, 'returning'];
        if ($this->alias !== null) {
            $components[] = [Format::type_keyword, 'as'];
            $components[] = [Format::type_columns, $this->alias];
        }
        $components[] = [Format::type_block_end];
        return $this->compose(!!$this->column, $components);
    }

}
