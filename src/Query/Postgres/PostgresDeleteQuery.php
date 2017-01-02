<?php

namespace Ejacobs\Phequel\Query\Postgres;

use Ejacobs\Phequel\Query\AbstractDeleteQuery;

class PostgresDeleteQuery extends AbstractDeleteQuery
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

        return (string)$this->deleteComponent
        . (string)$this->tableComponent
        . (string)$this->whereComponent;
    }

}