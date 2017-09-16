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
     * @param string|array $column
     * @param string $operator
     * @param string|array $value
     */
    public function where($column, $operator, $value)
    {
        $this->conditions[] = new ConditionComponent($column, $operator, $value);
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

            // More Conditions
            if ($condition instanceof ConditionsComponent) {
                $components[] = [Format::type_open_paren, null, Format::spacing_no_indent];
                $components[] = [Format::type_indentation, null, true];
                $components[] = $condition;
                $components[] = [Format::type_block_end, null, true];
                $components[] = [Format::type_close_paren];
            }
            else if ($condition instanceof ConditionComponent) {
                $components[] = $condition;
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
        }
        return $ret;
    }

}
