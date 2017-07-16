<?php

namespace Ejacobs\Phequel\Components;

use Ejacobs\Phequel\AbstractExpression;

class OperatorComponent extends AbstractExpression
{
    private $operator;

    /**
     * OperatorComponent constructor.
     * @param $operator
     */
    public function __construct($operator)
    {
        $this->operator = $operator;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return ' ' . $this->operator;
    }

}
