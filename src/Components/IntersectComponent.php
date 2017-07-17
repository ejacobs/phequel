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
        $formatter = $this->format();
        return $formatter->insert(Format::type_primary_keyword, 'intersect')
            . $formatter->insert(Format::type_block_end);
    }

}
