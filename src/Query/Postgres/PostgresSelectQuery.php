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
        // SELECT ALL OR DISTINCT
        $ret = "SELECT " . implode(', ', $this->selectComponents);

        $ret .= ' FROM ' . $this->tableComponent;

        if ($this->joinComponents) {
            $ret .= ' ' . implode(' ', $this->joinComponents) . ' ';
        }

        if ($this->whereComponents) {
            $ret .= ' WHERE ';
            $ret .= implode(' AND ', $this->whereComponents);
        }

        // GROUP BY
        // HAVING
        // WINDOW

        if (isset($this->orderByComponent)) {
            $ret .= ' ' . $this->orderByComponent;
        }

        if (isset($this->limitComponent)) {
            $ret .= ' ' . $this->limitComponent;
        }

        if (isset($this->offsetComponent)) {
            $ret .= ' ' . $this->offsetComponent;
        }

        // FETCH
        // FOR

        return $ret;
    }


}