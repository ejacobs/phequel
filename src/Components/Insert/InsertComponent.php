<?php

namespace Ejacobs\Phequel\Components\Insert;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Format;

class InsertComponent extends AbstractExpression
{

    private $table;

    /**
     * InsertComponent constructor.
     * @param $table
     */
    public function __construct($table)
    {
        $this->table = $table;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->compose(true, [
            [Format::type_block_keyword, 'insert into'],
            [Format::type_table, $this->table],
            [Format::type_block_end]
        ]);
    }

}
