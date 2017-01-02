<?php

namespace Ejacobs\QueryBuilder\Query\Postgres;

use Ejacobs\QueryBuilder\Component\Select\FetchComponent;
use Ejacobs\QueryBuilder\Component\Select\ForComponent;
use Ejacobs\QueryBuilder\Component\Select\WindowComponent;
use Ejacobs\QueryBuilder\Query\AbstractSelectQuery;

class PostgresSelectQuery extends AbstractSelectQuery
{

    /* @var WindowComponent $windowComponent */
    protected $windowComponent;

    /* @var FetchComponent $fetchComponent */
    protected $fetchComponent;

    /* @var ForComponent $forComponent */
    protected $forComponent;

    public function __construct($tableName = null)
    {
        $this->windowComponent = new WindowComponent();
        $this->fetchComponent = new FetchComponent();
        $this->forComponent = new ForComponent();
        parent::__construct($tableName);
    }

    /**
     * @param $column
     * @return $this
     */
    public function window($column)
    {
        $this->windowComponent->addWindow($column);
        return $this;
    }

    /**
     * @param string $lockStrength
     * @param null|string|array $table
     * @param null|string $option
     * @return $this
     */
    public function forLock($lockStrength, $table = null, $option = null)
    {
        $this->forComponent->setFor($lockStrength, $table, $option);
        return $this;
    }

    /**
     * @param $count
     * @param string $rowType
     * @param string $type
     * @return $this
     */
    public function fetchOnly($type = 'first', $count = 1, $rowType = 'rows')
    {
        $this->fetchComponent->setFetch($type, $count, $rowType);
        return $this;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function __toString()
    {
        if ($this->tableComponent === null) {
            throw new \Exception("You must specify a table name");
        }

        return (string)$this->selectComponent
        . (string)$this->tableComponent
        . (string)$this->joinComponent
        . (string)$this->whereComponent
        . (string)$this->groupByComponent
        . (string)$this->havingComponent
        . (string)$this->windowComponent
        . (string)$this->orderByComponent
        . (string)$this->limitComponent
        . (string)$this->offsetComponent
        . (string)$this->fetchComponent
        . (string)$this->forComponent
        . (string)$this->unionIntersectComponent;
    }

}
