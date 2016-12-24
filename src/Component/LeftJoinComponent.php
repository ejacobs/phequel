<?php

namespace Ejacobs\QueryBuilder\Component;


class LeftJoinComponent extends AbstractComponent
{
    private $tableName;
    private $onClause;

    public function __construct($tableName, $onClause)
    {
        $this->tableName = $tableName;
        $this->onClause = $onClause;
    }

    public function __toString()
    {
        return 'LEFT JOIN ' . $this->tableName . ' ON (' . $this->onClause . ')';
    }

}
