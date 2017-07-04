<?php

namespace Ejacobs\Phequel\Dialects\Psql;

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
     * @param null|string $tableName
     * @param array $allowedWildcards
     */
    public function __construct($tableName = null, $allowedWildcards = ['%' => '%', '_' => '_'])
    {
        $this->windowComponent = new WindowComponent();
        $this->fetchComponent = new FetchComponent();
        $this->forComponent = new ForComponent();
        parent::__construct($tableName, $allowedWildcards);
    }

    /**
     * @param $column
     * @return $this
     */
    public function window($column)
    {
        $this->windowComponent->addWindow($column);
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
     * @param $count
     * @param string $rowType
     * @param string $type
     * @return $this
     */
    public function fetchOnly($type = 'first', $count = 1, $rowType = 'rows')
    {
        $this->fetchComponent->setFetch($type, $count, $rowType);
        return $this;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function __toString()
    {
        if ($this->tableComponent === null) {
            throw new \Exception("You must specify a table name");
        }

        return $this->formatter()->compose([
            $this->selectComponent,
            $this->tableComponent,
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
            $this->unionIntersectComponent,
        ]);
    }

}
