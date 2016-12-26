<?php

namespace Ejacobs\QueryBuilder\Query;

use Ejacobs\QueryBuilder\Component\Select\GroupByComponent;
use Ejacobs\QueryBuilder\Component\Select\OrderByComponent;
use Ejacobs\QueryBuilder\Component\TableComponent;
use Ejacobs\QueryBuilder\Component\Select\JoinComponent;
use Ejacobs\QueryBuilder\Component\Select\LimitComponent;
use Ejacobs\QueryBuilder\Component\Select\OffsetComponent;
use Ejacobs\QueryBuilder\Component\Select\SelectComponent;
use Ejacobs\QueryBuilder\Component\WhereComponent;

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
     * @param array|string $expressions
     * @param array|string|int $params
     * @return $this
     */
    public function where($expressions, $params = [])
    {
        if (!($expressions instanceof WhereComponent)) {
            $expressions = new WhereComponent($expressions, $params, 'and');
        }
        $this->whereComponent->addConditions($expressions);
        return $this;
    }

    /**
     * @param array $expressions
     * @param array $params
     * @return $this
     */
    public function whereAny($expressions = [], $params = [])
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
    public function limit($limit = null)
    {
        $this->limitComponent = new LimitComponent($limit);
        return $this;
    }

    /**
     * @param array|string $columns
     * @return $this
     */
    public function groupBy($columns)
    {
        $this->groupByComponent->addColumns($columns);
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

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->whereComponent->getParams();
    }

}