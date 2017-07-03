<?php

namespace Ejacobs\Phequel\Queries;

use Ejacobs\Phequel\Query\AbstractDeleteQuery;
use Ejacobs\Phequel\Query\AbstractInsertQuery;
use Ejacobs\Phequel\Query\AbstractSelectQuery;
use Ejacobs\Phequel\Query\AbstractUpdateQuery;

/**
 * Interface QueriesInterface
 *
 * Queries include all DML queries (select, insert, update, delete) but adds the ability to begin transactions.
 * This is to differentiate from nested queries which are nested within a transaction and thus cannot begin a new
 * transaction.
 *
 * @package Ejacobs\Phequel\Queries
 */
interface QueriesInterface
{

    /**
     * @param $tableName
     * @return AbstractSelectQuery
     */
    public function select($tableName);

    /**
     * @param $tableName
     * @return AbstractInsertQuery
     */
    public function insert($tableName);

    /**
     * @param $tableName
     * @return AbstractDeleteQuery
     */
    public function delete($tableName);

    /**
     * @param $tableName
     * @return AbstractUpdateQuery
     */
    public function update($tableName);

    /**
     * @param callable $nested
     * @return mixed
     */
    public function transaction(callable $nested);


}