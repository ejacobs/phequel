<?php

namespace Ejacobs\Phequel\Components;

use Ejacobs\Phequel\AbstractExpression;

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
        $formatter = $this->formatter();
        $conditions = $this->conditions;
        $ret = '';
        while ($condition = array_shift($conditions)) {
            if ($condition instanceof ConditionsComponent) {
                $condition->formatter($formatter);
                $ret .= $formatter->insert($formatter::type_indentation, null, true);
                $ret .= (string)$condition;
                $ret .= $formatter->insert($formatter::type_end, null, true);
            } else {
                $ret .= $formatter->insert($formatter::type_condition, $condition);
                if ($conditions) {
                    $ret .= $formatter->insert($formatter::type_keyword, $this->type);
                }
            }
        }
        return $ret;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        $ret = [];
        foreach ($this->conditions as $condition) {
            $ret[] = $condition[2];
        }
        return $ret;
    }

}
