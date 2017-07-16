<?php

namespace Ejacobs\Phequel\Dialects\Psql;

use Ejacobs\Phequel\Components\IntersectComponent;
use Ejacobs\Phequel\Components\UnionComponent;
use Ejacobs\Phequel\Query\AbstractUnionIntersectQuery;

class PsqlUnionIntersectQuery extends AbstractUnionIntersectQuery
{

    /**
     * @param $tableName
     * @param bool $all
     * @return \Ejacobs\Phequel\Query\AbstractSelectQuery
     */
    public function union($tableName, $all = false)
    {
        return $this->add(new UnionComponent($all), new PsqlSelectQuery($tableName));
    }

    /**
     * @param callable $tableName
     * @return \Ejacobs\Phequel\Query\AbstractSelectQuery
     */
    public function intersect($tableName)
    {
        return $this->add(new IntersectComponent(), new PsqlSelectQuery($tableName));
    }

}
