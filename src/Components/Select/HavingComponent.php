<?php

namespace Ejacobs\Phequel\Components\Select;

use Ejacobs\Phequel\Components\AbstractComponent;
use Ejacobs\Phequel\Components\ConditionsComponent;

class HavingComponent extends AbstractComponent
{
    private $conditions;

    /**
     * HavingComponent constructor.
     */
    public function __construct()
    {
        $this->conditions = new ConditionsComponent();
    }

    /**
     * @param $column
     * @param $operator
     * @param $value
     */
    public function having($column, $operator, $value)
    {
        $this->conditions->where($column, $operator, $value);
    }

    /**
     * @param callable $nested
     */
    public function havingAny(callable $nested)
    {
        $this->conditions->whereAny($nested);
    }

    /**
     * @param callable $nested
     */
    public function havingAll(callable $nested)
    {
        $this->conditions->whereAll($nested);
    }

    /**
     * @return array|mixed
     */
    public function getParams()
    {
        $params = [];
        foreach ($this->conditions as $condition) {
            $params = array_merge($params, $condition['params']);
        }
        return $params;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (!$this->conditions->hasConditions()) {
            return '';
        }
        $formatter = $this->formatter();
        return $formatter->insert($formatter::type_block_keyword, 'having')
            . $this->conditions->injectFormatter($formatter)
            . $formatter->insert($formatter::type_end);
    }

}
