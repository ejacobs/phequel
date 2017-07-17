<?php

namespace Ejacobs\Phequel\Components\Transaction;

use Ejacobs\Phequel\AbstractExpression;

class ReleaseComponent extends AbstractExpression
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
        return $this->format()->insertKeyword('release savepoint ') . $this->savepointName . ";\n";
    }

}
