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
     * @param string $alias
     * @param string $statement
     * @return $this
     */
    public function window($alias, $statement)
    {
        $this->windowComponent->addWindow($alias, $statement);
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
