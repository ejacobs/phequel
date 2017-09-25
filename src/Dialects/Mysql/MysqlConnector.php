<?php

namespace Ejacobs\Phequel\Dialects\Mysql;

use Ejacobs\Phequel\Connector\AbstractPdoConnector;

/**
 * Class MysqlConnector
 * @package Ejacobs\Phequel\Dialects\Mysql
 */
class MysqlConnector extends AbstractPdoConnector
{

    const driver = 'mysql';

    /**
     * @param array|null $columns
     * @return MysqlSelectQuery
     */
    public function select(array $columns = [])
    {
        return new MysqlSelectQuery($columns);
    }

    /**
     * @param array|null $rows
     * @return MysqlInsertQuery
     */
    public function insert(array $rows = null)
    {
        return new MysqlInsertQuery($rows);
    }

    /**
     * @return MysqlDeleteQuery
     */
    public function delete()
    {
        return new MysqlDeleteQuery();
    }

    /**
     * @param string $tableName
     * @return MysqlUpdateQuery
     */
    public function update($tableName)
    {
        return new MysqlUpdateQuery($tableName);
    }

    /**
     * @param callable $nested
     * @return MysqlTransactionQuery
     */
    public function transaction(callable $nested)
    {
        return new MysqlTransactionQuery($nested);
    }

    /**
     * @param callable $queries
     * @return MysqlUnionIntersectQuery
     */
    public function unionIntersect(callable $queries)
    {
        return new MysqlUnionIntersectQuery($queries);
    }

}