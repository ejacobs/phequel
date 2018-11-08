<?php

namespace Phion\Phequel\Dialects\Mysql;

use Phion\Phequel\Query\AbstractUpdateQuery;

class MysqlUpdateQuery extends AbstractUpdateQuery
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