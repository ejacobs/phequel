<?php

namespace Phion\Phequel\Dialects\Mysql;

use Phion\Phequel\Components\IntersectComponent;
use Phion\Phequel\Components\UnionComponent;
use Phion\Phequel\Query\AbstractUnionIntersectQuery;

class MysqlUnionIntersectQuery extends AbstractUnionIntersectQuery
{

    /**
     * @param $tableName
     * @param bool $all
     * @return \Phion\Phequel\Query\AbstractSelectQuery
     */
    public function union($tableName, $all = false)
    {
        return $this->add(new UnionComponent($all), new MysqlSelectQuery($tableName));
    }

    /**
     * @param callable $tableName
     * @return \Phion\Phequel\Query\AbstractSelectQuery
     */
    public function intersect($tableName)
    {
        return $this->add(new IntersectComponent(), new MysqlSelectQuery($tableName));
    }

}
