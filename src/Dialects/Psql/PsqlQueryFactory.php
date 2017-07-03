<?php

namespace Ejacobs\Phequel\Dialects\Psql;

use Ejacobs\Phequel\Factories\QueryFactoryInterface;

class PsqlQueryFactory implements QueryFactoryInterface
{

    /**
     * @param string $tableName
     * @return PsqlSelectQuery
     */
    public function select($tableName)
    {
        return new PsqlSelectQuery($tableName);
    }

    /**
     * @param string $tableName
     * @return PsqlInsertQuery
     */
    public function insert($tableName)
    {
        return new PsqlInsertQuery($tableName);
    }

    /**
     * @param string $tableName
     * @return PsqlDeleteQuery
     */
    public function delete($tableName)
    {
        return new PsqlDeleteQuery($tableName);
    }

    /**
     * @param string $tableName
     * @return PsqlUpdateQuery
     */
    public function update($tableName)
    {
        return new PsqlUpdateQuery($tableName);
    }

    /**
     * @param callable $nested
     * @return PsqlTransactionQuery
     */
    public function transaction(callable $nested)
    {
        return new PsqlTransactionQuery($nested);
    }

}