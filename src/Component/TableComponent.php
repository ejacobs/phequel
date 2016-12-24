<?php

namespace Ejacobs\QueryBuilder\Component;


class TableComponent extends AbstractComponent
{
    private $tableName;

    public function __construct($tableName)
    {
        $this->tableName = $tableName;
    }

    public function __toString()
    {
        return $this->tableName;
    }

}
