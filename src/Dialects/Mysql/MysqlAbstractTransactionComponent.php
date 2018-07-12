<?php

namespace Ejacobs\Phequel\Dialects\Mysql;

use Ejacobs\Phequel\Components\AbstractTransactionComponent;
use Ejacobs\Phequel\Components\Transaction\ReleaseComponent;
use Ejacobs\Phequel\Components\Transaction\RollbackComponent;
use Ejacobs\Phequel\Components\Transaction\SavepointComponent;

class MysqlAbstractTransactionComponent extends AbstractTransactionComponent
{

    /* @var \Ejacobs\Phequel\AbstractExpression[] $queries */
    private $queries = [];

    public function select(array $columns = [])
    {
        return $this->queries[] = new MysqlSelectQuery($columns);
    }

    public function insert(array $rows = [])
    {
        return $this->queries[] = new MysqlInsertQuery($rows);
    }

    public function delete()
    {
        return $this->queries[] = new MysqlDeleteQuery();
    }

    public function update($tableName)
    {
        return $this->queries[] = new MysqlUpdateQuery($tableName);
    }

    public function savepoint($name)
    {
        return $this->queries[] = new SavepointComponent($name);
    }

    public function rollback($toSavepoint = null)
    {
        return $this->queries[] = new RollbackComponent($toSavepoint);
    }

    public function releaseSavepoint($name)
    {
        return $this->queries[] = new ReleaseComponent($name);
    }

    public function getParams()
    {
        $params = [];
        foreach ($this->queries as $query) {
            $params = array_merge($params, $query->getParams());
        }
        return $params;
    }

    public function toString()
    {
        return $this->compose(true, $this->queries);
    }

}