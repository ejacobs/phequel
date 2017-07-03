<?php

namespace Ejacobs\Phequel\Components\Insert;

use Ejacobs\Phequel\Components\AbstractComponent;

class InsertComponent extends AbstractComponent
{

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->formatter()->insertKeyword('insert into');
    }

}
