<?php

namespace Ejacobs\Phequel\Components;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Format;
use Ejacobs\Phequel\Query\AbstractBaseQuery;

class ConditionsComponent extends AbstractExpression
{
    private $conditions = [];
    private $type;
    private $level;

    public function __construct($type = 'and', $level = 0)
    {
        $this->type = $type;
        $this->level = $level;
    }

    /**
     * @param string $column
     * @param string $operator
     * @param string $value
     */
    public function where($column, $operator, $value)
    {
        $this->conditions[] = [$column, $operator, $value];
    }

    /**
     * @param callable $nested
     */
    public function whereAny(callable $nested)
    {
        $newWhereComponent = new ConditionsComponent('or', $this->level + 1);
        $nested($newWhereComponent);
        $this->conditions[] = $newWhereComponent;
    }

    /**
     * @param callable $nested
     */
    public function whereAll(callable $nested)
    {
        $newWhereComponent = new ConditionsComponent('and', $this->level + 1);
        $nested($newWhereComponent);
        $this->conditions[] = $newWhereComponent;
    }

    /**
     * @return bool
     */
    public function hasConditions()
    {
        return !!$this->conditions;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $components = [];
        $conditions = $this->conditions;
        while ($condition = array_shift($conditions)) {
            if ($condition instanceof ConditionsComponent) {
                $components[] = [Format::type_indentation, null, true];
                $components[] = $condition;
                $components[] = [Format::type_block_end, null, true];
            } else {
                if ($condition[2] instanceof AbstractBaseQuery) {
                    $selectQuery = array_pop($condition);
                    $components[] = [Format::type_condition, $condition];
                    $components[] = [Format::type_indentation, null, true];
                    $components[] = $selectQuery;
                    $components[] = [Format::type_block_end, null, true];
                }
                else if (is_array($condition[2])) {
                    $array = array_pop($condition);
                    $components[] = [Format::type_condition, $condition];
                    $components[] = [Format::type_indentation, null];
                    $components[] = [Format::type_values, $array];
                    $components[] = [Format::type_block_end, null];
                }
                else {
                    $components[] = [Format::type_condition, $condition];
                }

                if ($conditions) {
                    $components[] = [Format::type_keyword, $this->type];
                }
            }
        }
        return $this->compose(true, $components);
    }

    /**
     * @return array
     */
    public function getParams()
    {
        $ret = [];
        foreach ($this->conditions as $condition) {
            if ($condition instanceof AbstractExpression) {
                $ret = array_merge($ret, $condition->getParams());
            }
            else {
                $ret[] = $condition[2];
            }
        }
        return $ret;
    }

}
