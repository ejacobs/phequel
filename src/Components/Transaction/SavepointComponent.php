<?php

namespace Ejacobs\Phequel\Components\Transaction;

use Ejacobs\Phequel\AbstractExpression;

class SavepointComponent extends AbstractExpression
{

    private $savepointName;

    /**
     * SavepointComponent constructor.
     * @param string $name
     */
    public function __construct($name)
    {
        $this->savepointName = $name;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->formatter()->insertKeyword('savepoint ') . $this->savepointName . ";\n";
    }

}
