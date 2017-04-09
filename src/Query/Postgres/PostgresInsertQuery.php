<?php

namespace Ejacobs\Phequel\Query\Postgres;

use Ejacobs\Phequel\Component\Insert\ReturningComponent;
use Ejacobs\Phequel\Query\AbstractInsertQuery;

class PostgresInsertQuery extends AbstractInsertQuery
{

    /* @var ReturningComponent $returningComponent */
    protected $returningComponent;

    public function __construct($tableName = null)
    {
        $this->returningComponent = new ReturningComponent();
        parent::__construct($tableName);
    }

    public function returning($column, $alias = null)
    {
        $this->returningComponent = new ReturningComponent($column, $alias);
        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->insertComponent
        . (string)$this->tableComponent
        . (string)$this->rowComponent
        . (string)$this->returningComponent;
    }

}