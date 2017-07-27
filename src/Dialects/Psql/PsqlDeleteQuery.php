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
        return $this->compose(true, [
            $this->deleteComponent,
            $this->whereComponent,
        ]);
    }

}