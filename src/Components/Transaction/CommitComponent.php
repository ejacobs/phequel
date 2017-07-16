<?php

namespace Ejacobs\Phequel\Components\Transaction;

use Ejacobs\Phequel\AbstractExpression;

class CommitComponent extends AbstractExpression
{

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->formatter()->insertKeyword('commit') . ";\n";
    }

}
