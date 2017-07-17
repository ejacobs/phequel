<?php

namespace Ejacobs\Phequel\Components\Select;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Components\TableComponent;

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
        $formatter = $this->format();
        return $formatter->insert($formatter::type_block_keyword, 'from')
            . $formatter->insert($formatter::type_columns, [$this->table])
            . $formatter->insert($formatter::type_block_end);
    }

}
