<?php

namespace Phion\Phequel\Components\Transaction;

use Phion\Phequel\AbstractExpression;
use Phion\Phequel\Format;

class CommitComponent extends AbstractExpression
{

    /**
     * @return string
     */
    public function toString()
    {
        return $this->compose(true, [
            [Format::type_block_end],
            [Format::type_block_keyword, 'commit'],
            [Format::type_query_ending]
        ]);
    }

}
