<?php

namespace Ejacobs\Phequel\Components\Delete;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Format;

class DeleteComponent extends AbstractExpression
{
    private $table;
    private $alias;

    /**
     * DeleteComponent constructor.
     * @param null $table
     * @param null $alias
     */
    public function __construct($table = null, $alias = null)
    {
        $this->table = $table;
        $this->alias = $alias;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->compose(true, [
            [Format::type_block_keyword, 'delete from'],
            [Format::type_table, $this->table],
            [Format::type_alias, $this->alias],
            [Format::type_block_end]
        ]);
    }

}
