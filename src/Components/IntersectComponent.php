<?php

namespace Phion\Phequel\Components;

use Phion\Phequel\AbstractExpression;
use Phion\Phequel\Format;

class IntersectComponent extends AbstractExpression
{

    /**
     * @return string
     */
    public function toString()
    {
        return $this->compose(true, [
            [Format::type_primary_keyword, 'intersect'],
            [Format::type_block_end]
        ]);
    }

}
