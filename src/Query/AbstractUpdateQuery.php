<?php

namespace Ejacobs\QueryBuilder\Query;

use Ejacobs\QueryBuilder\Component\Update\SetComponent;
use Ejacobs\QueryBuilder\Component\TableComponent;
use Ejacobs\QueryBuilder\Component\Update\UpdateComponent;
use Ejacobs\QueryBuilder\Component\WhereComponent;

abstract class AbstractUpdateQuery extends AbstractBaseQuery
{
    /* @var UpdateComponent $updateComponent */
    protected $updateComponent;

    /* @var SetComponent $setComponent */
    protected $setComponent;

    /* @var WhereComponent $whereComponent */
    protected $whereComponent;


    public function __construct($tableName = null)
    {
        $this->updateComponent = new UpdateComponent();
        $this->setComponent = new SetComponent();
        $this->whereComponent = new WhereComponent();
        parent::__construct($tableName);
    }

    /**
     * @param $tableName
     * @return $this
     */
    public function update($tableName)
    {
        $this->tableComponent = new TableComponent($tableName);
        return $this;
    }

    /**
     * @param string $column
     * @param string $value
     * @return $this
     */
    public function set($column, $value)
    {
        $this->setComponent->setValue($column, $value);
        return $this;
    }

    /**
     * @param array $values
     * @return $this
     */
    public function setMultiple($values)
    {
        foreach ($values as $column => $value) {
            $this->setComponent->setValue($column, $value);
        }
        return $this;
    }

    /**
     * @param $expression
     * @param array $params
     * @return $this
     */
    public function where($expression, $params = [])
    {
        $this->whereComponent->addConditions($expression, $params);
        return $this;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        $params = [];
        foreach ($this->setComponent->getParams() as $value) {
            $params[] = $value;
        }
        foreach ($this->whereComponent->getParams() as $value) {
            $params[] = $value;
        }
        return $params;
    }

}