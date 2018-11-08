<?php

namespace Phion\Phequel\Components\Transaction;

use Phion\Phequel\AbstractExpression;
use Phion\Phequel\Format;

class SavepointComponent extends AbstractExpression
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
            [Format::type_block_end],
            [Format::type_block_keyword, 'savepoint'],
            [Format::type_table, $this->savepointName],
            [Format::type_block_end],
            [Format::type_query_ending],
            [Format::type_indentation, false],
        ]);
    }

}
