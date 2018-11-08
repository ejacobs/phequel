<?php

namespace Phion\Phequel\Dialects\Mysql;

use Phion\Phequel\Query\AbstractDeleteQuery;

class MysqlDeleteQuery extends AbstractDeleteQuery
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