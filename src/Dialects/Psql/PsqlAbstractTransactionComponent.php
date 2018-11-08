<?php

namespace Phion\Phequel\Dialects\Psql;

use Phion\Phequel\Components\AbstractTransactionComponent;
use Phion\Phequel\Components\Transaction\ReleaseComponent;
use Phion\Phequel\Components\Transaction\RollbackComponent;
use Phion\Phequel\Components\Transaction\SavepointComponent;

class PsqlAbstractTransactionComponent extends AbstractTransactionComponent
{

    /* @var \Phion\Phequel\AbstractExpression[] $queries */
    private $queries = [];

    public function select(array $columns = [])
    {
        return $this->queries[] = new PsqlSelectQuery($columns);
    }

    public function insert(array $rows = [])
    {
        return $this->queries[] = new PsqlInsertQuery($rows);
    }

    public function delete()
    {
        return $this->queries[] = new PsqlDeleteQuery();
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

    public function toString()
    {
        return $this->compose(true, $this->queries);
    }

}