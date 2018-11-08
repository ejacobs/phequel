<?php

namespace Phion\Phequel\Components\Transaction;

use Phion\Phequel\AbstractExpression;
use Phion\Phequel\Format;

class ReleaseComponent extends AbstractExpression
{

    private $savepointName;

    /**
     * SavepointComponent constructor.
     * @param string $name
     */
    public function __construct($name)
    {
        $this->savepointName = $name;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->compose(!!$this->savepointName, [
            [Format::type_block_keyword, 'release savepoint'],
            [Format::type_columns, $this->savepointName],
            [Format::type_block_end],
            [Format::type_query_ending]
        ]);
    }

}
