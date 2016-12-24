<?php

namespace Ejacobs\QueryBuilder\Query\Postgres;

use Ejacobs\QueryBuilder\Query\AbstractUpdateQuery;

class PostgresUpdateQuery extends AbstractUpdateQuery
{

    /**
     * @return string
     */
    public function __toString()
    {
        $ret = 'UPDATE ' . $this->tableComponent . ' ';
        $ret .= 'SET ' . implode(', ', $this->setComponents) . ' ';
        if ($this->whereComponents) {
            $ret .= 'WHERE ' . implode(', ', $this->whereComponents) . ' ';
        }
        return $ret;
    }


}