<?php

namespace Ejacobs\QueryBuilder\Query\Postgres;

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

        $ret = (string)$this->selectComponent;
        $ret .= (string)$this->tableComponent;
        $ret .= (string)$this->joinComponent;
        $ret .= (string)$this->whereComponent;
        $ret .= (string)$this->groupByComponent;
        $ret .= (string)$this->havingComponent;
        $ret .= (string)$this->windowComponent;
        $ret .= (string)$this->orderByComponent;
        $ret .= (string)$this->limitComponent;
        $ret .= (string)$this->offsetComponent;

        // FETCH
        // FOR

        $ret .= ';';
        return $ret;
    }


}