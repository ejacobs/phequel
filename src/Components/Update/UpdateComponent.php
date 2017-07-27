<?php

namespace Ejacobs\Phequel\Components\Update;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Format;

class UpdateComponent extends AbstractExpression
{
    private $table;

    /**
     * UpdateComponent constructor.
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
        return $this->compose(!!$this->table, [
            [Format::type_primary_keyword, 'update'],
            [Format::type_table, $this->table],
            [Format::type_block_end],
        ]);
    }

}
