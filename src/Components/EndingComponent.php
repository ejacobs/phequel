<?php

namespace Phion\Phequel\Components;

use Phion\Phequel\AbstractExpression;
use Phion\Phequel\Format;

class EndingComponent extends AbstractExpression
{

    private $semicolon = true;

    /**
     * @param bool $semicolon
     * @return $this
     */
    public function semicolon($semicolon = true)
    {
        $this->semicolon = $semicolon;
        return $this;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->compose(true, [
            [Format::type_query_ending, $this->semicolon],
        ]);
    }

}
