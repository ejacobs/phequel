<?php

namespace Ejacobs\Phequel\Dialects\Mysql;

use Ejacobs\Phequel\Query\AbstractDeleteQuery;

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