<?php

namespace Ejacobs\Phequel\Component\Insert;

use Ejacobs\Phequel\Component\AbstractComponent;

class InsertComponent extends AbstractComponent
{

    /**
     * @return string
     */
    public function __toString()
    {
        return 'INSERT INTO';
    }

}
