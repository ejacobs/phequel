<?php

namespace Ejacobs\Phequel\Components\Transaction;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Format;

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
