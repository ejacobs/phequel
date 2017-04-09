<?php

namespace Ejacobs\Phequel\Query\Traits;

use Ejacobs\Phequel\Component\WhereComponent;

trait WhereTrait
{



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
            $where->setCondition($column, $operator, $this->escapeWildcards($param));
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
                $new->setCondition($expression[0], $expression[1], $this->escapeWildcards($expression[2]));
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
                $new->setCondition($expression[0], $expression[1], $this->escapeWildcards($expression[2]));
                $expression = $new;
            }
            $where->addCondition($expression);
        }
        $this->whereComponent->addCondition($where);
        return $this;
    }

}