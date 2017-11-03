<?php

namespace Ejacobs\Phequel\Factories;

use Ejacobs\Phequel\Query\AbstractDeleteQuery;
use Ejacobs\Phequel\Query\AbstractInsertQuery;
use Ejacobs\Phequel\Query\AbstractSelectQuery;
use Ejacobs\Phequel\Query\AbstractTransactionQuery;
use Ejacobs\Phequel\Query\AbstractUpdateQuery;

/**
 * Interface QueryFactoryInterface
 *
 * Queries include all DML queries (select, insert, update, delete) but adds the ability to begin transactions.
 * This is to differentiate from nested queries which are already nested within a transaction and thus cannot begin a
 * new one.
 *
 * @package Ejacobs\Phequel\Queries
 */
interface QueryFactoryInterface
{

    /**
     * @param array $columns
     * @return AbstractSelectQuery
     */
    public function select(array $columns = []);

    /**
     * @param array $rows
     * @return AbstractInsertQuery
     */
    public function insert(array $rows = []);

    /**
     * @return AbstractDeleteQuery
     */
    public function delete();

    /**
     * @param string $tableName
     * @param string|null $alias
     * @return AbstractUpdateQuery
     */
    public function update($tableName, $alias = null);

    /**
     * @param callable $nested
     * @return AbstractTransactionQuery
     */
    public function transaction(callable $nested);


}