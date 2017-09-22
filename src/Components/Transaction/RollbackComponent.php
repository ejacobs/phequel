<?php

namespace Ejacobs\Phequel\Components\Transaction;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Format;

class RollbackComponent extends AbstractExpression
{

    private $rollbackTo;

    /**
     * RollbackComponent constructor.
     * @param null|string $rollbackTo
     */
    public function __construct($rollbackTo = null)
    {
        $this->rollbackTo = $rollbackTo;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $components = [];
        $components[] = [Format::type_block_end];
        $components[] = [Format::type_block_keyword, 'rollback'];
        if (is_string($this->rollbackTo)) {
            $components[] = [Format::type_keyword, 'to'];
            $components[] = [Format::type_columns, $this->rollbackTo];
        }
        $components[] = [Format::type_block_end];
        $components[] = [Format::type_query_ending];
        $components[] = [Format::type_indentation, false];
        return $this->compose(true, $components);
    }

}
