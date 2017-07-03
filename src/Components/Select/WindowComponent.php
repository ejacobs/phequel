<?php

namespace Ejacobs\Phequel\Components\Select;

use Ejacobs\Phequel\Components\AbstractComponent;

class WindowComponent extends AbstractComponent
{
    private $windows = [];

    /**
     * WindowComponent constructor.
     * @param null $column
     */
    public function __construct($column = null)
    {
        if ($column) {
            $this->addWindow($column);
        }
    }

    /**
     * @param $column
     */
    public function addWindow($column)
    {
        $this->windows[] = $column;
    }

    public function __toString()
    {
        if ($this->windows) {
            return $this->formatter()->insertKeyword(' window ') . implode(', ', $this->windows);
        } else {
            return '';
        }
    }

}
