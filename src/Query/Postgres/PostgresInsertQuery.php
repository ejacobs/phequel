<?php

namespace Ejacobs\Phequel\Query\Postgres;

use Ejacobs\Phequel\Query\AbstractInsertQuery;

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