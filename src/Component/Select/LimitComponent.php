<?php

namespace Ejacobs\QueryBuilder\Component\Select;

use Ejacobs\QueryBuilder\Component\AbstractComponent;

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
        }
        else {
            return '';
        }

    }

}
