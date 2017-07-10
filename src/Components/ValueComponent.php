<?php

namespace Ejacobs\Phequel\Components;


class ValueComponent extends AbstractComponent
{
    private $value;

    /**
     * ValueComponent constructor.
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function actualValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->formatter()->insertPlaceholder($this->value);
    }

}
