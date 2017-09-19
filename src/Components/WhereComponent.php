<?php

namespace Ejacobs\Phequel\Components;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Format;
use Ejacobs\Phequel\Query\AbstractSelectQuery;

class WhereComponent extends AbstractExpression
{
    const valid_types = ['and', 'or'];
    private $conditions;

    /**
     * WhereComponent constructor.
     * @param string $type
     */
    public function __construct($type = 'and')
    {
        $this->conditions = new ConditionsComponent(strtolower($type));
    }

    /**
     * @param string $column
     * @param string $operator
     * @param string|AbstractSelectQuery $value
     */
    public function where($column, $operator, $value)
    {
        $this->conditions->where($column, $operator, $value);
    }

    /**
     * @param callable $nested
     */
    public function whereAny(callable $nested)
    {
        $this->conditions->whereAny($nested);
    }

    /**
     * @param callable $nested
     */
    public function whereAll(callable $nested)
    {
        $this->conditions->whereAll($nested);
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->conditions->getParams();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->compose($this->conditions->hasConditions(), [
            [Format::type_block_keyword, 'where'],
            $this->conditions,
            [Format::type_block_end]
        ]);
    }

}
