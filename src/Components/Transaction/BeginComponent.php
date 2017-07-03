<?php

namespace Ejacobs\Phequel\Components\Transaction;

use Ejacobs\Phequel\Components\AbstractComponent;

class BeginComponent extends AbstractComponent
{

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->formatter()->insertKeyword('begin transaction') . ";\n";
    }

}
