<?php

namespace Ejacobs\Phequel\Components\Select;

use Ejacobs\Phequel\Components\AbstractComponent;

class OffsetComponent extends AbstractComponent
{
    private $offset;

    /**
     * SelectComponent constructor.
     * @param int|null $offset
     */
    public function __construct($offset = null)
    {
        $this->offset = $offset;
    }

    public function __toString()
    {
        if ($this->offset !== null) {
            return $this->formatter()->insertKeyword(' offset ') . $this->offset;
        } else {
            return '';
        }
    }

}
