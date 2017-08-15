<?php

namespace Ejacobs\Phequel\Dialects\Psql;

use Ejacobs\Phequel\Components\Transaction\ReleaseComponent;
use Ejacobs\Phequel\Components\Transaction\RollbackComponent;
use Ejacobs\Phequel\Components\Transaction\SavepointComponent;
use Ejacobs\Phequel\Components\AbstractTransactionComponent;

class PsqlAbstractTransactionComponent extends AbstractTransactionComponent
{
    /* @var \Ejacobs\Phequel\AbstractExpression[] $queries */
    private $queries = [];

    public function select($tableName, $alias = null)
    {
        return $this->queries[] = new PsqlSelectQuery($tableName, $alias);
    }

    public function insert($tableName)
    {
        return $this->queries[] = new PsqlInsertQuery($tableName);
    }

    public function delete($tableName)
    {
        return $this->queries[] = new PsqlDeleteQuery($tableName);
    }

    public function update($tableName)
    {
        return $this->queries[] = new PsqlUpdateQuery($tableName);
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

    public function __toString()
    {
        return $this->compose(true, $this->queries);
    }

}