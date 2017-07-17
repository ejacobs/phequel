<?php

namespace Ejacobs\Phequel\Dialects\Psql;

use Ejacobs\Phequel\Query\AbstractDeleteQuery;

class PsqlDeleteQuery extends AbstractDeleteQuery
{

    /**
     * @return string
     * @throws \Exception
     */
    public function __toString()
    {
        return $this->format()->compose([
            $this->deleteComponent,
            $this->tableComponent,
            $this->whereComponent,
        ]);
    }

}