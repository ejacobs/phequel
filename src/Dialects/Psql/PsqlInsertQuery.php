<?php

namespace Phion\Phequel\Dialects\Psql;

use Phion\Phequel\Components\Insert\ReturningComponent;
use Phion\Phequel\Query\AbstractInsertQuery;

/**
 * Class PsqlInsertQuery
 * @package Phion\Phequel\Dialects\Psql
 */
class PsqlInsertQuery extends AbstractInsertQuery
{

    /* @var ReturningComponent $returningComponent */
    protected $returningComponent;

    /**
     * PsqlInsertQuery constructor.
     * @param array $rows
     */
    public function __construct(array $rows = [])
    {
        $this->returningComponent = new ReturningComponent();
        parent::__construct($rows);
    }

    /**
     * @param string $column
     * @param null|string $alias
     * @return $this
     */
    public function returning($column, $alias = null)
    {
        $this->returningComponent = new ReturningComponent($column, $alias);
        return $this;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->compose(true, [
            $this->insertComponent,
            $this->rowsComponent,
            $this->returningComponent,
            $this->endingComponent
        ]);
    }

}