<?php

namespace Ejacobs\Phequel\Components\Insert;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Format;

class InsertComponent extends AbstractExpression
{

    private $table;
    private $alias;

    /**
     * InsertComponent constructor.
     * @param $table
     * @param $alias
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
        return $this->compose(true, [
            [Format::type_block_keyword, 'insert into'],
            [Format::type_table, $this->table],
            [Format::type_alias, $this->alias],
            [Format::type_block_end]
        ]);
    }

}
