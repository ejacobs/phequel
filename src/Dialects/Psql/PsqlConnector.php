<?php

namespace Phion\Phequel\Dialects\Psql;

use Phion\Phequel\Connector\AbstractPdoConnector;

/**
 * Class PsqlConnector
 * @package Phion\Phequel\Dialects\Psql
 */
class PsqlConnector extends AbstractPdoConnector
{

    const driver = 'pgsql';

    /**
     * @param array|null $columns
     * @return PsqlSelectQuery
     */
    public function select(array $columns = [])
    {
        return new PsqlSelectQuery($columns);
    }

    /**
     * @param array|null $rows
     * @return PsqlInsertQuery
     */
    public function insert(array $rows = [])
    {
        return new PsqlInsertQuery($rows);
    }

    /**
     * @return PsqlDeleteQuery
     */
    public function delete()
    {
        return new PsqlDeleteQuery();
    }

    /**
     * @param string $tableName
     * @param string|null $alias
     * @return PsqlUpdateQuery
     */
    public function update($tableName, $alias = null)
    {
        return new PsqlUpdateQuery($tableName, $alias);
    }

    /**
     * @param callable $nested
     * @return PsqlTransactionQuery
     */
    public function transaction(callable $nested)
    {
        return new PsqlTransactionQuery($nested);
    }

    /**
     * @param callable $queries
     * @return PsqlUnionIntersectQuery
     */
    public function unionIntersect(callable $queries)
    {
        return new PsqlUnionIntersectQuery($queries);
    }

}