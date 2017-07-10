<?php

namespace Ejacobs\Phequel\Components;

class BlockComponent extends AbstractComponent
{
    private $start;
    private $components;
    private $end;

    /**
     * BlockComponent constructor.
     * @param $start
     * @param $components
     * @param $end
     */
    public function __construct($start, $components, $end)
    {
        $this->start = $start;
        $this->components = $components;
        $this->end = $end;
    }


    /**
     * @return string
     */
    public function __toString()
    {

        return $this->formatter()->insertColumn($this->column);
    }

}
