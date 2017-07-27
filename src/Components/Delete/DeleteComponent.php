<?php

namespace Ejacobs\Phequel\Components\Delete;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Format;

class DeleteComponent extends AbstractExpression
{
    private $table;

    /**
     * DeleteComponent constructor.
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
            [Format::type_block_keyword, 'delete from'],
            [Format::type_table, $this->table],
            [Format::type_block_end]
        ]);
    }

}
