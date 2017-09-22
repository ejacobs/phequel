<?php

namespace Ejacobs\Phequel\Components;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Format;

class IntersectComponent extends AbstractExpression
{

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->compose(true, [
            [Format::type_primary_keyword, 'intersect'],
            [Format::type_block_end]
        ]);
    }

}
