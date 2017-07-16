<?php

namespace Ejacobs\Phequel\Components;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Formatter;
use Ejacobs\Phequel\Query\AbstractSelectQuery;

class WhereComponent extends AbstractExpression
{
    private $conditions;
    private $level = 0;
    private $type;

    const valid_types = ['and', 'or'];

    /**
     * WhereComponent constructor.
     * @param string $type
     * @param int $level
     * @throws \Exception
     */
    public function __construct($type = 'and', $level = 0)
    {
        $this->conditions = new ConditionsComponent($type);
        $this->level = $level;
        $type = strtolower($type);
        if (in_array($type, self::valid_types)) {
            $this->type = $type;
        } else {
            throw new \Exception("Where conditions type must be one of the following: " . implode(', ', self::valid_types));
        }
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
            [Formatter::type_block_keyword, 'where'],
            $this->conditions,
            [Formatter::type_end]
        ]);
    }

}
