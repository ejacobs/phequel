<?php

namespace Ejacobs\Phequel\Components\Select;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Format;

class FromComponent extends AbstractExpression
{
    /* @var string $table */
    private $table;

    /* @var null|string $alias */
    private $alias;

    /**
     * FromComponent constructor.
     * @param string $table
     * @param null|string $alias
     */
    public function __construct($table, $alias = null)
    {
        $this->table = $table;
        $this->alias = $alias;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $components = [];
        $components[] = [Format::type_block_keyword, 'from'];
        $components[] = [Format::type_columns, $this->table];
        if ($this->alias !== null) {
            $components[] = [Format::type_keyword, 'as'];
            $components[] = [Format::type_statement, $this->alias];
        }
        $components[] = [Format::type_block_end];
        return $this->compose(true, $components);
    }

}
