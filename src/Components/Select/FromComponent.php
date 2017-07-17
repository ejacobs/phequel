<?php

namespace Ejacobs\Phequel\Components\Select;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Components\TableComponent;
use Ejacobs\Phequel\Format;

class FromComponent extends AbstractExpression
{
    /* @var TableComponent $table */
    private $table;

    /**
     * FromComponent constructor.
     * @param string $table
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
            [Format::type_block_keyword, 'from'],
            [Format::type_columns, $this->table],
            [Format::type_block_end]
        ]);
    }

}
