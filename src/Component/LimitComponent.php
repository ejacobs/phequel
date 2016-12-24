<?php

namespace Ejacobs\QueryBuilder\Component;

class LimitComponent extends AbstractComponent
{
    private $limit;

    /**
     * LimitComponent constructor.
     * @param int $limit
     */
    public function __construct($limit)
    {
        $this->limit = $limit;
    }

    public function __toString()
    {
        return "LIMIT {$this->limit} ";
    }

}
