<?php

namespace Ejacobs\Phequel\Connector;

use Ejacobs\Phequel\Query\AbstractDeleteQuery;
use Ejacobs\Phequel\Query\AbstractInsertQuery;
use Ejacobs\Phequel\Query\AbstractSelectQuery;
use Ejacobs\Phequel\Query\AbstractUpdateQuery;

abstract class AbstractConnector
{
    abstract public function connect();

    abstract public function execute($query, $params = []);

    abstract public function fetchAll($query, $params = []);

    abstract public function firstRow($query, $params = []);

    abstract public function lastInsertId($name = null);

    abstract public function disconnect();

    // Query builder

    /**
     * @param $tableName
     * @return AbstractSelectQuery
     */
    abstract public function select($tableName);

    /**
     * @param $tableName
     * @return AbstractInsertQuery
     */
    abstract public function insert($tableName);

    /**
     * @param $tableName
     * @return AbstractDeleteQuery
     */
    abstract public function delete($tableName);

    /**
     * @param $tableName
     * @return AbstractUpdateQuery
     */
    abstract public function update($tableName);


    abstract public function beginTransaction();

    abstract public function commit();

    abstract public function rollback();

    abstract public function errorInfo();

}