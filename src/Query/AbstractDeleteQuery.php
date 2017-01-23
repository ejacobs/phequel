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
        if (is_array($column)) {
            if ($operator === null) {
                $operator = 'and';
            }
            $component = new WhereComponent(null, null, null, $operator);
            foreach ($column as $subWhere) {
                $component->addCondition(new WhereComponent($subWhere[0], $subWhere[1], $subWhere[2]));
            }
            $this->whereComponent->addCondition($component);
        } else if ($column instanceof WhereComponent) {
            $this->whereComponent->addCondition($column);
        } else {
            $this->whereComponent->addCondition(new WhereComponent($column, $operator, $param));
        }
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