<?php

namespace Ejacobs\QueryBuilder\Query\Postgres;

use Ejacobs\QueryBuilder\Component\Select\WindowComponent;
use Ejacobs\QueryBuilder\Query\AbstractSelectQuery;

class PostgresSelectQuery extends AbstractSelectQuery
{

    /* @var WindowComponent $windowComponent */
    protected $windowComponent;

    public function __construct($tableName = null)
    {
        $this->windowComponent = new WindowComponent();
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
     * @return string
     * @throws \Exception
     */
    public function __toString()
    {
        if ($this->tableComponent === null) {
            throw new \Exception("You must specify a table name");
        }

        $ret = (string)$this->selectComponent;
        $ret .= (string)$this->tableComponent;
        $ret .= (string)$this->joinComponent;
        $ret .= (string)$this->whereComponent;
        $ret .= (string)$this->groupByComponent;
        $ret .= (string)$this->havingComponent;
        $ret .= (string)$this->windowComponent;
        $ret .= (string)$this->orderByComponent;
        $ret .= (string)$this->limitComponent;
        $ret .= (string)$this->offsetComponent;

        // FETCH
        // FOR

        $ret .= ';';
        return $ret;
    }


}