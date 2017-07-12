<?php

namespace Ejacobs\Phequel\Dialects\Psql;

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
        $keyword = 'union';
        if ($all) {
            $keyword .= ' all';
        }
        return $this->add($keyword, new PsqlSelectQuery($tableName));
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
