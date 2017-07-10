<?php

namespace Ejacobs\Phequel\Dialects\Psql;

use Ejacobs\Phequel\Components\Transaction\ReleaseComponent;
use Ejacobs\Phequel\Components\Transaction\RollbackComponent;
use Ejacobs\Phequel\Components\Transaction\SavepointComponent;
use Ejacobs\Phequel\Components\AbstractTransactionComponent;

class PsqlAbstractTransactionComponent extends AbstractTransactionComponent
{
    private $queries = [];

    public function select($tableName)
    {
        return $this->queries[] = new PsqlSelectQuery($tableName);
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
        // TODO: Implement getParams() method.
    }

    public function __toString()
    {
        $ret = '';
        foreach ($this->queries as $query) {
            $ret .= "\t{$query};\n";
        }
        return $ret;
    }

}