<?php

namespace Ejacobs\Phequel\Components\Transaction;

use Ejacobs\Phequel\AbstractExpression;

class BeginComponent extends AbstractExpression
{

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->format()->insertKeyword('begin transaction') . ";\n";
    }

}
