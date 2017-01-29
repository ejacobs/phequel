<?php

namespace Ejacobs\Phequel\Connector\PdoConnector;

use Ejacobs\Phequel\Query\Postgres\PostgresDeleteQuery;
use Ejacobs\Phequel\Query\Postgres\PostgresInsertQuery;
use Ejacobs\Phequel\Query\Postgres\PostgresSelectQuery;

/**
 * Class PdoConnector
 * @package Ejacobs\Phequel\Connector\
 * @method \PDO getNextConnection()
 * @method \PDO[] pool()
 */
class PostgresConnector extends AbstractPdoConnector
{
    const driver = 'pgsql';

    /**
     * @param $tableName
     * @return PostgresSelectQuery
     */
    public function select($tableName)
    {
        return new PostgresSelectQuery($tableName);
    }

    /**
     * @param $tableName
     * @return PostgresInsertQuery
     */
    public function insert($tableName)
    {
        return new PostgresInsertQuery($tableName);
    }

    /**
     * @param $tableName
     * @return PostgresDeleteQuery
     */
    public function delete($tableName)
    {
        return new PostgresDeleteQuery($tableName);
    }

    /**
     * @param $tableName
     * @return PostgresDeleteQuery
     */
    public function update($tableName)
    {
        return new PostgresDeleteQuery($tableName);
    }

    /**
     * @return bool
     */
    public function beginTransaction()
    {
        return $this->execute('BEGIN TRANSACTION');
    }

    /**
     * @return bool
     */
    public function commit()
    {
        return $this->execute('COMMIT');
    }

    /**
     * @return bool
     */
    public function rollback()
    {
        return $this->execute('ROLLBACK');
    }


}