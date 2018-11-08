<?php

namespace Phion\Phequel\Query;

use Phion\Phequel\Components\Select\ColumnComponent;
use Phion\Phequel\Components\Select\ColumnFunctionComponent;
use Phion\Phequel\Components\Select\ColumnJsonComponent;
use Phion\Phequel\Components\Select\ColumnRawComponent;
use Phion\Phequel\Components\Select\FromComponent;
use Phion\Phequel\Components\Select\FromRawComponent;
use Phion\Phequel\Components\Select\GroupByComponent;
use Phion\Phequel\Components\Select\HavingComponent;
use Phion\Phequel\Components\Select\JoinComponent;
use Phion\Phequel\Components\Select\LimitComponent;
use Phion\Phequel\Components\Select\OffsetComponent;
use Phion\Phequel\Components\Select\OrderByComponent;
use Phion\Phequel\Components\Select\SelectComponent;
use Phion\Phequel\Components\WhereComponent;
use Phion\Phequel\Query\Traits\WhereTrait;

abstract class AbstractSelectQuery extends AbstractBaseQuery
{

    use WhereTrait;

    const valid_json_operators = ['->', '->>', '#>', '#>>'];

    /* @var SelectComponent $selectComponent */
    protected $selectComponent;

    /* @var FromComponent $fromComponent */
    protected $fromComponent;

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

    /**
     * AbstractSelectQuery constructor.
     * @param array $columns
     */
    public function __construct(array $columns = [])
    {
        $this->selectComponent = new SelectComponent();
        $this->fromComponent = new FromComponent();
        $this->whereComponent = new WhereComponent();
        $this->joinComponent = new JoinComponent();
        $this->groupByComponent = new GroupByComponent();
        $this->orderByComponent = new OrderByComponent();
        $this->limitComponent = new LimitComponent();
        $this->offsetComponent = new OffsetComponent();
        $this->havingComponent = new HavingComponent();
        $this->selectMany($columns);
        parent::__construct();
    }

    /**
     * @param string $tableName
     * @param null|string $alias
     * @return $this
     */
    public function from($tableName, $alias = null)
    {
        $this->fromComponent = new FromComponent($tableName, $alias);
        return $this;
    }


    /**
     * @param string $tableName
     * @param null|string $alias
     * @return $this
     */
    public function fromRaw($raw, $alias = null)
    {
        $this->fromComponent = new FromRawComponent($raw, $alias);
        return $this;
    }

    /**
     * @param $column
     * @param null $alias
     * @return $this
     */
    public function select($column, $alias = null)
    {
        $this->selectComponent->addColumn(new ColumnComponent($column, $alias));
        return $this;
    }

    /**
     * @param array $columns
     * @return $this
     */
    public function selectMany(array $columns)
    {
        foreach ($columns as $column) {
            $this->selectComponent->addColumn(new ColumnComponent($column[0], $column[1] ?? null));
        }
        return $this;
    }


    /**
     * @param $column
     * @param null $alias
     * @return $this
     */
    public function selectRaw($column, $alias = null)
    {
        $this->selectComponent->addColumn(new ColumnRawComponent($column, $alias));
        return $this;
    }

    /**
     * @param $function
     * @param $column
     * @param $alias
     * @return $this
     */
    public function selectFunction($function, $column, $alias)
    {
        $this->selectComponent->addColumn(new ColumnFunctionComponent($function, $column, $alias));
        return $this;
    }

    /**
     * @return $this
     */
    public function clearSelect()
    {
        $this->selectComponent->clearColumns();
        return $this;
    }

    /**
     * @param bool $distinct
     * @param null|string $on
     * @return $this
     */
    public function distinct($distinct = true, $on = null)
    {
        $this->selectComponent->setDistinct($distinct, $on);
        return $this;
    }

    /**
     * @param string $tableName
     * @param string $tableAlias
     * @param callable $conditions
     * @return $this
     */
    public function leftJoin($tableName, $tableAlias, callable $conditions)
    {
        $this->joinComponent->addJoin($tableName, $tableAlias, $conditions, 'left');
        return $this;
    }

    /**
     * @param string $tableName
     * @param string $tableAlias
     * @param callable $conditions
     * @return $this
     */
    public function rightJoin($tableName, $tableAlias, callable $conditions)
    {
        $this->joinComponent->addJoin($tableName, $tableAlias, $conditions, 'right');
        return $this;
    }

    /**
     * @param string $tableName
     * @param string $tableAlias
     * @param callable $conditions
     * @return $this
     */
    public function innerJoin($tableName, $tableAlias, callable $conditions)
    {
        $this->joinComponent->addJoin($tableName, $tableAlias, $conditions, 'inner');
        return $this;
    }

    /**
     * @param string $tableName
     * @param string $tableAlias
     * @param callable $conditions
     * @return $this
     */
    public function outerJoin($tableName, $tableAlias, callable $conditions)
    {
        $this->joinComponent->addJoin($tableName, $tableAlias, $conditions, 'outer');
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
     * @param $column
     * @param $operator
     * @param $value
     * @return $this
     */
    public function having($column, $operator, $value)
    {
        $this->havingComponent->having($column, $operator, $value);
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
     * @param string|null $direction
     * @return $this
     */
    public function orderBy($column, $direction = null)
    {
        $this->orderByComponent->addOrderBy($column, $direction);
        return $this;
    }

    /**
     * @return $this
     */
    public function clearOrderBy()
    {
        $this->orderByComponent = new OrderByComponent();
        return $this;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->replaceWildcardsParams([
            $this->joinComponent->getParams(),
            $this->whereComponent->getParams()
        ]);
    }

    /**
     * When cloning, clone all sub-components
     */
    public function __clone()
    {
        $this->selectComponent = clone $this->selectComponent;
        $this->fromComponent = clone $this->fromComponent;
        $this->joinComponent = clone $this->joinComponent;
        $this->whereComponent = clone $this->whereComponent;
        $this->limitComponent = clone $this->limitComponent;
        $this->offsetComponent = clone $this->offsetComponent;
        $this->groupByComponent = clone $this->groupByComponent;
        $this->orderByComponent = clone $this->orderByComponent;
        $this->havingComponent = clone $this->havingComponent;
    }


}