<?php

namespace Ejacobs\QueryBuilder\Query;

use Ejacobs\QueryBuilder\Component\TableComponent;
use Ejacobs\QueryBuilder\FluentConnection;

abstract class AbstractBaseQuery
{
    protected $tableComponent = null;

    /**
     * AbstractBaseQuery constructor.
     * @param $tableName
     */
    public function __construct($tableName)
    {
        $this->tableComponent = new TableComponent($tableName);
    }

    /**
     * @return string
     */
    abstract public function __toString();

    /**
     * @return array
     */
    abstract public function getParams();


}