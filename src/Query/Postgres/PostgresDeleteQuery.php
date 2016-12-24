<?php

namespace Ejacobs\QueryBuilder\Query\Postgres;

use Ejacobs\QueryBuilder\Query\AbstractDeleteQuery;

class PostgresDeleteQuery extends AbstractDeleteQuery
{

    /**
     * @return string
     */
    public function __toString()
    {
        $ret = 'DELETE FROM ' . $this->tableComponent . ' ';
        $ret .= implode(', ', $this->joinComponents);
        if ($this->whereComponents) {
            $ret .= 'WHERE ';
            $ret .= implode(' AND ', $this->whereComponents);
            $ret .= ' ';
        }
        return $ret;
    }


}