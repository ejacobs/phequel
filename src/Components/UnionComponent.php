<?php

namespace Ejacobs\Phequel\Components;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Format;

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
        $formatter = $this->format();
        if ($this->all) {
            return $formatter->insert(Format::type_primary_keyword, 'union all')
                . $formatter->insert(Format::type_block_end);
        } else {
            return $formatter->insert(Format::type_primary_keyword, 'union')
                . $formatter->insert(Format::type_block_end);
        }
    }

}
