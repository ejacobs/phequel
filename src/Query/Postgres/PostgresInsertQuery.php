<?php

namespace Ejacobs\QueryBuilder\Query\Postgres;

use Ejacobs\QueryBuilder\Query\AbstractInsertQuery;

class PostgresInsertQuery extends AbstractInsertQuery
{

    /**
     * @return string
     */
    public function __toString()
    {
        $ret = 'INSERT INTO ' . $this->tableComponent . ' ';
        $ret .= '(' . implode(', ', $this->columns) . ') VALUES ';
        $ret .= implode(",\n", $this->insertRowComponents);
        return $ret;
    }

}