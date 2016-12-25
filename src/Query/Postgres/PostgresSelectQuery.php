<?php

namespace Ejacobs\QueryBuilder\Query\Postgres;

use Ejacobs\QueryBuilder\Query\AbstractSelectQuery;

class PostgresSelectQuery extends AbstractSelectQuery
{

    /**
     * @return string
     */
    public function __toString()
    {
        $ret = "SELECT " . implode(', ', $this->selectComponents) . ' FROM ' . $this->tableComponent . ' ';
        if ($this->joinComponents) {
            $ret .= implode(' ', $this->joinComponents) . ' ';
        }
        if ($this->whereComponents) {
            $ret .= 'WHERE ';
            $ret .= implode(' AND ', $this->whereComponents) . ' ';
        }

        if (isset($this->orderByComponent)) {
            $ret .= $this->orderByComponent;
        }

        if (isset($this->limitComponent)) {
            $ret .= $this->limitComponent;
        }

        if (isset($this->offsetComponent)) {
            $ret .= $this->offsetComponent;
        }

        return $ret;
    }


}