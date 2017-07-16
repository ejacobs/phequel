<?php

namespace Ejacobs\Phequel\Components;

use Ejacobs\Phequel\AbstractExpression;

class NumberComponent extends AbstractExpression
{
    private $number;

    public function __construct($number)
    {
        if (!is_numeric($number) && !is_null($number)) {
            throw new \Exception('Number must be numeric: ' . $number);
        }
        $this->number = $number;
    }

    public function __toString()
    {
        return $this->formatter()->insertNumber($this->number);
    }

}
