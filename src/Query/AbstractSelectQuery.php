<?php

namespace Ejacobs\QueryBuilder\Query;

use Ejacobs\QueryBuilder\Component\Select\Json;
use Ejacobs\QueryBuilder\Component\OrderByComponent;
use Ejacobs\QueryBuilder\Component\TableComponent;
use Ejacobs\QueryBuilder\Component\LeftJoinComponent;
use Ejacobs\QueryBuilder\Component\LimitComponent;
use Ejacobs\QueryBuilder\Component\OffsetComponent;
use Ejacobs\QueryBuilder\Component\SelectComponent;
use Ejacobs\QueryBuilder\Component\WhereComponent;

class AbstractSelectQuery extends AbstractBaseQuery
{

    /* @var SelectComponent[] $selectComponents */
    protected $selectComponents = [];

    /* @var LeftJoinComponent[] $whereComponents */
    protected $joinComponents = [];

    /* @var WhereComponent[] $whereComponents */
    protected $whereComponents = [];

    /* @var LimitComponent $whereComponents */
    protected $limitComponent;

    /* @var OffsetComponent $whereComponents */
    protected $offsetComponent;

    /* @var OrderByComponent $orderByComponent */
    protected $orderByComponent;

    /**
     * @param $tableName
     * @return $this
     */
    public function from($tableName)
    {
        $this->tableComponent = new TableComponent($tableName);
        return $this;
    }

    /**
     * @param $column
     * @param null $alias
     * @return $this
     */
    public function select($column, $alias = null)
    {
        $this->selectComponents[] = new SelectComponent($column, $alias);
        return $this;
    }

    /**
     * @param $tableName
     * @param $onClause
     * @return $this
     */
    public function leftJoin($tableName, $onClause)
    {
        $this->joinComponents[] = new LeftJoinComponent($tableName, $onClause);
        return $this;
    }

    /**
     * @param string $expression
     * @param array $params
     * @return $this
     */
    public function where($expression, $params = [])
    {
        $this->whereComponents[] = new WhereComponent($expression, $params);
        return $this;
    }

    /**
     * @param int $limit
     * @return $this
     */
    public function limit($limit = null)
    {
        $this->limitComponent = new LimitComponent($limit);
        return $this;
    }

    /**
     * @param int $offset
     * @return $this
     */
    public function offset($offset = null)
    {
        $this->offsetComponent = new OffsetComponent($offset);
        return $this;
    }

    /**
     * @param $column
     * @param string $direction
     * @return $this
     */
    public function orderBy($column, $direction = 'ASC')
    {
        $this->orderByComponent = new OrderByComponent($column, $direction);
        return $this;
    }

    public function getParams()
    {
        $params = [];
        foreach ($this->whereComponents as $whereComponent) {
            $params = array_merge($params, $whereComponent->getParams());
        }
        return $params;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $ret = "SELECT " . implode(', ', $this->selectComponents) . ' FROM ' . $this->tableComponent . ' ';
        if ($this->joinComponents) {
            $ret .= implode(' ', $this->joinComponents) . ' ';
        }
        if ($this->whereComponents) {
            $ret .= 'WHERE ';
            $ret .= implode(' AND ', $this->whereComponents) . ' ';
        }

        if (isset($this->orderByComponent)) {
            $ret .= $this->orderByComponent;
        }

        if (isset($this->limitComponent)) {
            $ret .= $this->limitComponent;
        }

        if (isset($this->offsetComponent)) {
            $ret .= $this->offsetComponent;
        }

        return $ret;
    }


}