<?php

namespace Phion\Phequel\Components;

use Phion\Phequel\AbstractExpression;
use Phion\Phequel\Query\AbstractDeleteQuery;
use Phion\Phequel\Query\AbstractInsertQuery;
use Phion\Phequel\Query\AbstractSelectQuery;
use Phion\Phequel\Query\AbstractUpdateQuery;

/**
 * Class AbstractTransactionComponent
 *
 * Nested Queries include all DML queries (select, insert, update, delete) but are only available within the nested
 * callback of a transaction. As such, nested queries include transaction level controls such as savepoints and
 * rollbacks. Unlike QueryFactoryInterface, nested queries retain all created queries so that the nested block can be
 * serialized as a single string.
 *
 * @package Phion\Phequel\Components
 */
abstract class AbstractTransactionComponent extends AbstractExpression
{

    /**
     * @param array|null $columns
     * @return mixed
     */
    abstract public function select(array $columns = []);

    /**
     * @param array $rows
     * @return mixed
     */
    abstract public function insert(array $rows = []);

    /**
     * @return mixed
     */
    abstract public function delete();

    /**
     * @param string $tableName
     * @return mixed
     */
    abstract public function update($tableName);

    /**
     * @param string $name
     */
    abstract public function savepoint($name);

    /**
     * @param null|string $toSavepoint
     */
    abstract public function rollback($toSavepoint = null);

    /**
     * @param string $name
     */
    abstract public function releaseSavepoint($name);

}
