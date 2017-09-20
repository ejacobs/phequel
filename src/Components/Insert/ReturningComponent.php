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
        return $this->compose((bool)$this->column, [
            [Format::type_block_keyword, 'returning'],
            [Format::type_alias, $this->alias],
            [Format::type_block_end]
        ]);
    }

}
