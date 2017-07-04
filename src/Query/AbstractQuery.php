<?php

namespace Ejacobs\Phequel\Query;

use Ejacobs\Phequel\Formatter;

abstract class AbstractQuery
{
    /** @param Formatter $formatter */
    private $formatter;

    /**
     * @return string
     */
    abstract public function __toString();

    /**
     * @return Formatter
     */
    public function formatter()
    {
        if ($this->formatter instanceof Formatter) {
            return $this->formatter;
        }
        return $this->formatter = new Formatter($this);
    }

}