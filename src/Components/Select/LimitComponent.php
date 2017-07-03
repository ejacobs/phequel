<?php

namespace Ejacobs\Phequel\Component\Select;

use Ejacobs\Phequel\Component\AbstractComponent;

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
            return " LIMIT {$this->limit}";
        } else {
            return '';
        }

    }

}
