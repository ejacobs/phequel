<?php

namespace Ejacobs\Phequel\Components\Delete;

use Ejacobs\Phequel\Components\AbstractComponent;

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
