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
     * @param string $tableName
     * @param null|string $alias
     * @return mixed
     */
    public function select($tableName, $alias = null);

    /**
     * @param string $tableName
     * @return AbstractInsertQuery
     */
    public function insert($tableName);

    /**
     * @param string $tableName
     * @return AbstractDeleteQuery
     */
    public function delete($tableName);

    /**
     * @param string $tableName
     * @return AbstractUpdateQuery
     */
    public function update($tableName);

    /**
     * @param callable $nested
     * @return AbstractTransactionQuery
     */
    public function transaction(callable $nested);


}