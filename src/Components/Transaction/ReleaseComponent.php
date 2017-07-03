<?php

namespace Ejacobs\Phequel\Components\Transaction;

use Ejacobs\Phequel\Components\AbstractComponent;

class ReleaseComponent extends AbstractComponent
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
        return $this->formatter()->insertKeyword('release savepoint ') . $this->savepointName . ";\n";
    }

}
