<?php

namespace Ejacobs\Phequel\Query\Traits;

use Ejacobs\Phequel\Formatter;

/**
 * Trait FormatterTrait
 * @package Ejacobs\Phequel\Query\Traits
 */
trait FormatterTrait
{

    private $formatter;

    /**
     * @param Formatter $formatter
     * @return $this
     */
    public function format(Formatter $formatter)
    {
        $this->formatter = $formatter;
        return $this;
    }

    /**
     * @return Formatter
     */
    protected function formatter()
    {
        if ($this->formatter instanceof Formatter) {
            return $this->formatter;
        }
        return new Formatter();
    }

}