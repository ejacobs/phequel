<?php

namespace Ejacobs\QueryBuilder\Query\Postgres;

use Ejacobs\QueryBuilder\Component\AndComponent;
use Ejacobs\QueryBuilder\Component\WhereComponent;
use Ejacobs\QueryBuilder\Query\AbstractSelectQuery;

class PostgresSelectQuery extends AbstractSelectQuery
{

    /**
     * @return string
     * @throws \Exception
     */
    public function __toString()
    {
        if ($this->tableComponent === null) {
            throw new \Exception("You must specify a table name");
        }
        // SELECT ALL OR DISTINCT
        $ret = "SELECT " . implode(', ', $this->columnComponents);

        $ret .= ' FROM ' . $this->tableComponent;

        if ($this->joinComponents) {
            $ret .= ' ' . implode(' ', $this->joinComponents) . ' ';
        }

        if ($this->whereComponents) {
            $ret .= ' WHERE ';
            $ret .= (string)(new WhereComponent($this->whereComponents));
        }

        $ret .= (string)$this->groupByComponent;
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
        $ret .= ';';
        // FETCH
        // FOR

        return $ret;
    }


}