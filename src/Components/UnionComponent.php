<?php

namespace Ejacobs\Phequel\Components;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Formatter;

class UnionComponent extends AbstractExpression
{
    private $all;

    /**
     * UnionComponent constructor.
     * @param bool $all
     */
    public function __construct($all = false)
    {
        $this->all = $all;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $formatter = $this->formatter();
        if ($this->all) {
            return $formatter->insert(Formatter::type_primary_keyword, 'union all')
                . $formatter->insert(Formatter::type_end);
        } else {
            return $formatter->insert(Formatter::type_primary_keyword, 'union')
                . $formatter->insert(Formatter::type_end);
        }
    }

}
