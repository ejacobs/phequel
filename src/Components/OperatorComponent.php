<?php

namespace Ejacobs\Phequel\Components;


class OperatorComponent extends AbstractComponent
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
