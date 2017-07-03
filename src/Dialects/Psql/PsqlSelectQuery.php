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

        $formatter = $this->formatter();
        return (string)$this->selectComponent->injectFormatter($formatter)
            . (string)$this->tableComponent->injectFormatter($formatter)
            . (string)$this->joinComponent->injectFormatter($formatter)
            . (string)$this->whereComponent->injectFormatter($formatter)
            . (string)$this->groupByComponent->injectFormatter($formatter)
            . (string)$this->havingComponent->injectFormatter($formatter)
            . (string)$this->windowComponent->injectFormatter($formatter)
            . (string)$this->orderByComponent->injectFormatter($formatter)
            . (string)$this->limitComponent->injectFormatter($formatter)
            . (string)$this->offsetComponent->injectFormatter($formatter)
            . (string)$this->fetchComponent->injectFormatter($formatter)
            . (string)$this->forComponent->injectFormatter($formatter)
            . (string)$this->unionIntersectComponent->injectFormatter($formatter);
    }

}
