<?php

namespace Phion\Phequel\Dialects\Psql;

use Phion\Phequel\Query\AbstractUpdateQuery;

class PsqlUpdateQuery extends AbstractUpdateQuery
{

    /**
     * @return string
     */
    public function toString()
    {
        return $this->compose(true, [
            $this->updateComponent,
            $this->setComponent,
            $this->whereComponent,
            $this->endingComponent
        ]);
    }

}