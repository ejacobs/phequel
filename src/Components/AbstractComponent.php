<?php

namespace Ejacobs\Phequel\Components;

use Ejacobs\Phequel\Formatter;

abstract class AbstractComponent
{
    /* @var Formatter $formatter */
    private $formatter;

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

    /**
     * @return Formatter
     */
    public function formatter()
    {
        if ($this->formatter instanceof Formatter) {
            return $this->formatter;
        }
        return $this->formatter = new Formatter();
    }

    /**
     * @param Formatter $formatter
     * @return $this
     */
    public function injectFormatter(Formatter $formatter)
    {
        $this->formatter = $formatter;
        return $this;
    }

}
