<?php

namespace Ejacobs\Phequel\Query;

use Ejacobs\Phequel\Component\Select\GroupByComponent;
use Ejacobs\Phequel\Component\Select\HavingComponent;
use Ejacobs\Phequel\Component\Select\OrderByComponent;
use Ejacobs\Phequel\Component\Select\UnionIntersectComponent;
use Ejacobs\Phequel\Component\TableComponent;
use Ejacobs\Phequel\Component\Select\JoinComponent;
use Ejacobs\Phequel\Component\Select\LimitComponent;
use Ejacobs\Phequel\Component\Select\OffsetComponent;
use Ejacobs\Phequel\Component\Select\SelectComponent;
use Ejacobs\Phequel\Component\WhereComponent;

abstract class AbstractSelectQuery extends AbstractBaseQuery
{

    /* @var SelectComponent $selectComponent */
    protected $selectComponent;

    /* @var JoinComponent $joinComponent */
    protected $joinComponent;

    /* @var WhereComponent $whereComponent */
    protected $whereComponent;

    /* @var LimitComponent $whereComponents */
    protected $limitComponent;

    /* @var OffsetComponent $whereComponents */
    protected $offsetComponent;

    /* @var GroupByComponent $groupByComponent */
    protected $groupByComponent;

    /* @var OrderByComponent $orderByComponent */
    protected $orderByComponent;

    /* @var HavingComponent $havingComponent */
    protected $havingComponent;

    /* @var UnionIntersectComponent $unionIntersectComponent */
    protected $unionIntersectComponent;


    /**
     * AbstractSelectQuery constructor.
     * @param $tableName
     */
    public function __construct($tableName = null)
    {
        $this->selectComponent = new SelectComponent();
        $this->whereComponent = new WhereComponent();
        $this->joinComponent = new JoinComponent();
        $this->groupByComponent = new GroupByComponent();
        $this->orderByComponent = new OrderByComponent();
        $this->limitComponent = new LimitComponent();
        $this->offsetComponent = new OffsetComponent();
        $this->havingComponent = new HavingComponent();
        $this->unionIntersectComponent = new UnionIntersectComponent();
        parent::__construct($tableName);
    }

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
     * @return $this
     */
    public function select($column)
    {
        $this->selectComponent->addColumns($column);
        return $this;
    }

    /**
     * @param bool $distinct
     * @param null $on
     * @return $this
     */
    public function distinct($distinct = true, $on = null)
    {
        $this->selectComponent->setDistinct($distinct, $on);
        return $this;
    }

    /**
     * @param $tableName
     * @param $onClause
     * @return $this
     */
    public function leftJoin($tableName, $onClause)
    {
        $this->joinComponent->addJoin($tableName, $onClause, 'left');
        return $this;
    }

    /**
     * @param $column
     * @param $operator
     * @param $param
     * @return $this
     */
    public function where($column, $operator = null, $param = null)
    {
        if (is_array($column)) {
            if ($operator === null) {
                $operator = 'and';
            }
            $component = new WhereComponent(null, null, null, $operator);
            foreach ($column as $subWhere) {
                $component->addCondition(new WhereComponent($subWhere[0], $subWhere[1], $subWhere[2]));
            }
            $this->whereComponent->addCondition($component);
        } else if ($column instanceof WhereComponent) {
            $this->whereComponent->addCondition($column);
        } else {
            $this->whereComponent->addCondition(new WhereComponent($column, $operator, $param));
        }
        return $this;
    }

    /**
     * @param array $expressions
     * @param array $params
     * @return $this
     */
    public
    function whereAny($expressions = [], $params = [])
    {
        if (!($expressions instanceof WhereComponent)) {
            $expressions = new WhereComponent($expressions, $params, 'or');
        }
        $this->whereComponent->addConditions($expressions);
        return $this;
    }

    /**
     * @param int $limit
     * @return $this
     */
    public
    function limit($limit = null)
    {
        $this->limitComponent = new LimitComponent($limit);
        return $this;
    }

    /**
     * @param array|string $columns
     * @return $this
     */
    public
    function groupBy($columns)
    {
        $this->groupByComponent->addColumns($columns);
        return $this;
    }

    /**
     * @param $sql
     * @param array $params
     * @return $this
     */
    public
    function having($sql, $params = [])
    {
        $this->havingComponent->addCondition($sql, $params);
        return $this;
    }

    /**
     * @param int $offset
     * @return $this
     */
    public
    function offset($offset = null)
    {
        $this->offsetComponent = new OffsetComponent($offset);
        return $this;
    }


    /**
     * @param $column
     * @param string $direction
     * @return $this
     */
    public
    function orderBy($column, $direction = 'ASC')
    {
        $this->orderByComponent = new OrderByComponent($column, $direction);
        return $this;
    }

    /**
     * @param $query
     * @param array $params
     * @return $this
     */
    public
    function union($query, $params = [])
    {
        $this->unionIntersectComponent->addUnion($query, $params);
        return $this;
    }

    /**
     * @param $query
     * @param array $params
     * @return $this
     */
    public
    function intersect($query, $params = [])
    {
        $this->unionIntersectComponent->addIntersect($query, $params);
        return $this;
    }

    /**
     * @return array
     */
    public
    function getParams()
    {
        return $this->whereComponent->getParams();
    }

}