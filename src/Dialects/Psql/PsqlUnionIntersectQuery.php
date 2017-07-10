<?php

namespace Ejacobs\Phequel\Dialects\Psql;

use Ejacobs\Phequel\Query\AbstractUnionIntersectQuery;

class PsqlUnionIntersectQuery extends AbstractUnionIntersectQuery
{

    /**
     * @param callable $tableName
     * @return \Ejacobs\Phequel\Query\AbstractSelectQuery
     */
    public function union($tableName)
    {
        return $this->add('union', new PsqlSelectQuery($tableName));
    }

    /**
     * @param callable $tableName
     * @return \Ejacobs\Phequel\Query\AbstractSelectQuery
     */
    public function intersect($tableName)
    {
        return $this->add('intersect', new PsqlSelectQuery($tableName));
    }

}
