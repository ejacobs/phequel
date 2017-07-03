<?php

namespace Ejacobs\Phequel\Components\Update;

use Ejacobs\Phequel\Components\AbstractComponent;

class UpdateComponent extends AbstractComponent
{

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->formatter()->insertKeyword('update');
    }

}
