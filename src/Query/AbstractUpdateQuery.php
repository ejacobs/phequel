<?php

namespace Ejacobs\Phequel\Query;

use Ejacobs\Phequel\Component\Update\SetComponent;
use Ejacobs\Phequel\Component\TableComponent;
use Ejacobs\Phequel\Component\Update\UpdateComponent;
use Ejacobs\Phequel\Component\WhereComponent;

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
     * @param $column
     * @param $operator
     * @param $param
     * @return $this
     */
    public function where($column, $operator = null, $param = null)
    {

        if ($column instanceof WhereComponent) {
            $where = $column;
        } else {
            $where = new WhereComponent();
            $where->setCondition($column, $operator, $param);
        }
        $this->whereComponent->addCondition($where);
        return $this;
    }

    /**
     * @param array $expressions
     * @return $this
     */
    public function whereAny($expressions = [])
    {
        $where = new WhereComponent('or');
        foreach ($expressions as $expression) {
            if (!($expression instanceof WhereComponent)) {
                $new = new WhereComponent();
                $new->setCondition($expression[0], $expression[1], $expression[2]);
                $expression = $new;
            }
            $where->addCondition($expression);
        }
        $this->whereComponent->addCondition($where);
        return $this;
    }


    /**
     * @param array $expressions
     * @return $this
     */
    public function whereAll($expressions = [])
    {
        $where = new WhereComponent('and');
        foreach ($expressions as $expression) {
            if (!($expression instanceof WhereComponent)) {
                $new = new WhereComponent();
                $new->setCondition($expression[0], $expression[1], $expression[2]);
                $expression = $new;
            }
            $where->addCondition($expression);
        }
        $this->whereComponent->addCondition($where);
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