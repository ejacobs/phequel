<?php

namespace Ejacobs\Phequel\Dialects\Mysql;

use Ejacobs\Phequel\Query\AbstractUpdateQuery;

class MysqlUpdateQuery extends AbstractUpdateQuery
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