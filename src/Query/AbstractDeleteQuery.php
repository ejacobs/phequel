<?php

namespace Ejacobs\Phequel\Query;

use Ejacobs\Phequel\Component\Delete\DeleteComponent;
use Ejacobs\Phequel\Component\TableComponent;
use Ejacobs\Phequel\Component\WhereComponent;

abstract class AbstractDeleteQuery extends AbstractBaseQuery
{
    /* @var DeleteComponent $whereComponent */
    protected $deleteComponent;

    /* @var WhereComponent $whereComponent */
    protected $whereComponent;

    /**
     * AbstractSelectQuery constructor.
     * @param $tableName
     */
    public function __construct($tableName = null)
    {
        $this->deleteComponent = new DeleteComponent();
        $this->whereComponent = new WhereComponent();
        parent::__construct($tableName);
    }

    /**
     * @param $tableName
     * @return $this
     */
    public function from($tableName)
    {
        $this->tableComponent = new TableComponent($tableName);
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
        return $this->whereComponent->getParams();
    }

}