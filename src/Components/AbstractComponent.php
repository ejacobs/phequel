<?php

namespace Ejacobs\Phequel\Component;

abstract class AbstractComponent
{


    /**
     * @return string
     */
    abstract public function __toString();

    /**
     * @return array
     */
    public function getParams()
    {
        return [];
    }

}
