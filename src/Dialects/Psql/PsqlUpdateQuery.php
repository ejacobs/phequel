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
        return $this->formatter()->compose([
            $this->updateComponent,
            $this->tableComponent,
            $this->setComponent,
            $this->whereComponent,
        ]);
    }

}