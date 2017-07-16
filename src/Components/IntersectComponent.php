<?php

namespace Ejacobs\Phequel\Components;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Formatter;

class IntersectComponent extends AbstractExpression
{
    /**
     * @return string
     */
    public function __toString()
    {
        $formatter = $this->formatter();
        return $formatter->insert(Formatter::type_primary_keyword, 'intersect')
            . $formatter->insert(Formatter::type_end);
    }

}
