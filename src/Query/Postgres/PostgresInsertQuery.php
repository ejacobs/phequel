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
        return (string)$this->insertComponent
        . (string)$this->tableComponent
        . (string)$this->rowComponent;
    }

}