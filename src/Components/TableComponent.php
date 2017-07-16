<?php

namespace Ejacobs\Phequel\Components;

use Ejacobs\Phequel\AbstractExpression;

class TableComponent extends AbstractExpression
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
