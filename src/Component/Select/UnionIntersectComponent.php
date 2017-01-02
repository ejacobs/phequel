<?php

namespace Ejacobs\QueryBuilder\Component\Select;

use Ejacobs\QueryBuilder\Component\AbstractComponent;
use Ejacobs\QueryBuilder\Query\AbstractSelectQuery;

class UnionIntersectComponent extends AbstractComponent
{
    private $queries = [];
    private $params = [];

    /**
     * @param string|AbstractSelectQuery $query
     * @param array $params
     */
    public function addUnion($query, $params = [])
    {
        $this->queries[] = ['union', $query];
        $this->params[] = $params;
    }

    /**
     * @param string|AbstractSelectQuery $query
     * @param array $params
     */
    public function addIntersect($query, $params = [])
    {
        $this->queries[] = ['intersect', $query];
        $this->params[] = $params;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        $ret = [];
        $queries = $this->queries;
        $params = $this->params;
        while ($query = array_pop($queries)) {
            $params = array_pop($params);
            if ($query instanceof AbstractSelectQuery) {
                $toAdd = $query->getParams();
            }
            else {
                $toAdd = $params;
            }

            foreach ($toAdd as $param) {
                $ret[] = $param;
            }
        }
        return $ret;
    }

    public function __toString()
    {
        $ret = '';
        foreach ($this->queries as $query) {
            $ret .= ' ' . strtoupper($query[0]) . ' ' . $query[1];
        }
        return $ret;
    }

}
