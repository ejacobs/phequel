<?php

namespace Ejacobs\Phequel\Components;

use Ejacobs\Phequel\Query\AbstractSelectQuery;

class WhereComponent extends AbstractComponent
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
        if (!$this->conditions->hasConditions()) {
            return '';
        }
        $formatter = $this->formatter();
        return $formatter->insert($formatter::type_block_keyword, 'where')
            . (string)$this->conditions->injectFormatter($formatter)
            . $formatter->insert($formatter::type_end);

    }

}
