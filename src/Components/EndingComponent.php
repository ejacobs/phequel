<?php

namespace Ejacobs\Phequel\Components;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Format;

class EndingComponent extends AbstractExpression
{
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->compose(true, [
            [Format::type_query_ending],
        ]);
    }

}
