<?php

namespace Ejacobs\Phequel\Components\Select;

use Ejacobs\Phequel\Components\AbstractComponent;

class LimitComponent extends AbstractComponent
{
    private $limit;

    /**
     * LimitComponent constructor.
     * @param int|null $limit
     */
    public function __construct($limit = null)
    {
        $this->limit = $limit;
    }

    public function __toString()
    {
        if ($this->limit) {
            return $this->formatter()->insertKeyword(' limit ') . $this->limit;
        } else {
            return '';
        }
    }

}
