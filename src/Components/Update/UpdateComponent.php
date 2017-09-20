<?php

namespace Ejacobs\Phequel\Components\Update;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Format;

class UpdateComponent extends AbstractExpression
{
    private $alias;
    private $table;

    /**
     * UpdateComponent constructor.
     * @param string $table
     * @param null $alias
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
        return $this->compose(!!$this->table, [
            [Format::type_primary_keyword, 'update'],
            [Format::type_table, $this->table],
            [Format::type_alias, $this->alias],
            [Format::type_block_end],
        ]);
    }

}
