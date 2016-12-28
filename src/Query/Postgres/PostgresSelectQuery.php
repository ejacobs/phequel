<?php

namespace Ejacobs\QueryBuilder\Query\Postgres;

use Ejacobs\QueryBuilder\Component\Select\FetchComponent;
use Ejacobs\QueryBuilder\Component\Select\WindowComponent;
use Ejacobs\QueryBuilder\Query\AbstractSelectQuery;

class PostgresSelectQuery extends AbstractSelectQuery
{

    /* @var WindowComponent $windowComponent */
    protected $windowComponent;

    /* @var FetchComponent $fetchComponent */
    protected $fetchComponent;


    public function __construct($tableName = null)
    {
        $this->windowComponent = new WindowComponent();
        $this->fetchComponent = new FetchComponent();
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
        $ret .= (string)$this->fetchComponent;

        // FOR

        $ret .= ';';
        return $ret;
    }


}