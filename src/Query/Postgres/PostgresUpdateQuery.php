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
        return  (string)$this->updateComponent
        . (string)$this->tableComponent
        . (string)$this->setComponent
        . (string)$this->whereComponent;
    }


}