<?php

namespace Ejacobs\Phequel\Component\Delete;

use Ejacobs\Phequel\Component\AbstractComponent;

class DeleteComponent extends AbstractComponent
{

    /**
     * @return string
     */
    public function __toString()
    {
        return 'DELETE FROM';
    }

}
