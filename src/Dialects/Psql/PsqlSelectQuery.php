<?php

namespace Ejacobs\Phequel\Dialects\Psql;

use Ejacobs\Phequel\Components\Select\ColumnOverAliasComponent;
use Ejacobs\Phequel\Components\Select\ColumnOverComponent;
use Ejacobs\Phequel\Components\Select\FetchComponent;
use Ejacobs\Phequel\Components\Select\ForComponent;
use Ejacobs\Phequel\Components\Select\WindowComponent;
use Ejacobs\Phequel\Query\AbstractSelectQuery;

class PsqlSelectQuery extends AbstractSelectQuery
{

    /* @var WindowComponent $windowComponent */
    protected $windowComponent;

    /* @var FetchComponent $fetchComponent */
    protected $fetchComponent;

    /* @var ForComponent $forComponent */
    protected $forComponent;

    /**
     * PsqlSelectQuery constructor.
     * @param string $tableName
     * @param null|string $alias
     */
    public function __construct($tableName = null, $alias = null)
    {
        $this->windowComponent = new WindowComponent();
        $this->fetchComponent = new FetchComponent();
        $this->forComponent = new ForComponent();
        parent::__construct($tableName, $alias);
    }

    /**
     * @param $function
     * @param $column
     * @param $partitionByColumns
     * @param array $orderBy
     * @return $this
     */
    public function selectOver($function, $column, $partitionByColumns, $orderBy = [])
    {
        $this->selectComponent->addColumn(new ColumnOverComponent($function, $column, $partitionByColumns, $orderBy));
        return $this;
    }

    /**
     * @param $function
     * @param $column
     * @param $windowAlias
     * @return $this
     */
    public function selectOverAlias($function, $column, $windowAlias)
    {
        $this->selectComponent->addColumn(new ColumnOverAliasComponent($function, $column, $windowAlias));
        return $this;
    }

    /**
     * @param $alias
     * @param $columns
     * @param $orderBy
     * @return $this
     */
    public function window($alias, $columns, $orderBy)
    {
        $this->windowComponent->addWindow($alias, $columns, $orderBy);
        return $this;
    }

    /**
     * @param string $lockStrength
     * @param null|string|array $table
     * @param null|string $option
     * @return $this
     */
    public function forLock($lockStrength, $table = null, $option = null)
    {
        $this->forComponent->setFor($lockStrength, $table, $option);
        return $this;
    }

    /**
     * @param string $firstNext
     * @param int $count
     * @return $this
     */
    public function fetch($firstNext, $count)
    {
        $this->fetchComponent->setFetch($firstNext, $count);
        return $this;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function __toString()
    {
        return $this->compose(true, [
            $this->selectComponent,
            $this->fromComponent,
            $this->joinComponent,
            $this->whereComponent,
            $this->groupByComponent,
            $this->havingComponent,
            $this->windowComponent,
            $this->orderByComponent,
            $this->limitComponent,
            $this->offsetComponent,
            $this->fetchComponent,
            $this->forComponent,
            $this->endingComponent
        ]);
    }

}
