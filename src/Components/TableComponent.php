<?php

namespace Ejacobs\Phequel\Components;


class TableComponent extends AbstractComponent
{
    private $tableName;

    /**
     * TableComponent constructor.
     * @param string $tableName
     */
    public function __construct($tableName)
    {
        $this->tableName = $tableName;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->tableName;
    }

}
