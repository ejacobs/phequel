<?php

namespace Ejacobs\Phequel\Query;

use Ejacobs\Phequel\Component\TableComponent;
use Ejacobs\Phequel\FluentConnection;

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