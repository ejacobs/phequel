<?php

namespace Ejacobs\Phequel\Dialects\Mysql;

use Ejacobs\Phequel\Components\IntersectComponent;
use Ejacobs\Phequel\Components\UnionComponent;
use Ejacobs\Phequel\Query\AbstractUnionIntersectQuery;

class MysqlUnionIntersectQuery extends AbstractUnionIntersectQuery
{

    /**
     * @param $tableName
     * @param bool $all
     * @return \Ejacobs\Phequel\Query\AbstractSelectQuery
     */
    public function union($tableName, $all = false)
    {
        return $this->add(new UnionComponent($all), new MysqlSelectQuery($tableName));
    }

    /**
     * @param callable $tableName
     * @return \Ejacobs\Phequel\Query\AbstractSelectQuery
     */
    public function intersect($tableName)
    {
        return $this->add(new IntersectComponent(), new MysqlSelectQuery($tableName));
    }

}
