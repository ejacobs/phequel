<?php

namespace Phion\Phequel\Components\Transaction;

use Phion\Phequel\AbstractExpression;
use Phion\Phequel\Format;

class BeginComponent extends AbstractExpression
{

    /**
     * @return string
     */
    public function toString()
    {
        return $this->compose(true, [
            [Format::type_block_keyword, 'begin transaction'],
            [Format::type_query_ending]
        ]);
    }

}
