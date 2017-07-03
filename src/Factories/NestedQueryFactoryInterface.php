<?php

namespace Ejacobs\Phequel\Queries;

use Ejacobs\Phequel\Query\AbstractDeleteQuery;
use Ejacobs\Phequel\Query\AbstractInsertQuery;
use Ejacobs\Phequel\Query\AbstractSelectQuery;
use Ejacobs\Phequel\Query\AbstractUpdateQuery;

/**
 * Interface NestedQueriesInterface
 *
 * Nested Queries include all DML queries (select, insert, update, delete) but are only available within the nested
 * callback of a transaction. As such, nested queries include transaction level controls such as savepoints and
 * rollbacks. Unlike QueriesInterface, nested queries retain all created queries so that the nested block can be
 * serialized as a single string.
 *
 * @package Ejacobs\Phequel\Queries
 */
interface NestedQueriesInterface extends QueriesInterface
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
     * @param string $name
     */
    public function savepoint($name);

    /**
     * @param null|string $toSavepoint
     */
    public function rollback($toSavepoint = null);

    /**
     * @param string $name
     */
    public function releaseSavepoint($name);

    /**
     * @return array
     */
    public function getParams();

    /**
     * @return string
     */
    public function __toString();

}