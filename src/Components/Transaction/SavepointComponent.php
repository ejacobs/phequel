<?php

namespace Ejacobs\Phequel\Components\Transaction;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Format;

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
    public function __toString()
    {
        return $this->compose(!!$this->savepointName, [
            [Format::type_block_keyword, 'savepoint'],
            [Format::type_keyword, $this->savepointName],
            [Format::type_block_end]
        ]);
    }

}
