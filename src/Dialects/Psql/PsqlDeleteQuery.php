<?php

namespace Phion\Phequel\Dialects\Psql;

use Phion\Phequel\Query\AbstractDeleteQuery;

class PsqlDeleteQuery extends AbstractDeleteQuery
{

    /**
     * @return string
     * @throws \Exception
     */
    public function toString()
    {
        return $this->compose(true, [
            $this->deleteComponent,
            $this->whereComponent,
            $this->endingComponent
        ]);
    }

}