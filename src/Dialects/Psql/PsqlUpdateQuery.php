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
        return $this->compose(true, [
            $this->updateComponent,
            $this->setComponent,
            $this->whereComponent,
            $this->endingComponent
        ]);
    }

}