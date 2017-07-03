<?php

namespace Ejacobs\Phequel\Dialects\Psql;

use Ejacobs\Phequel\Query\AbstractUpdateQuery;

class PsqlUpdateQuery extends AbstractUpdateQuery
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