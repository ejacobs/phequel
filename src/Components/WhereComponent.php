<?php

namespace Ejacobs\Phequel\Components;

use Ejacobs\Phequel\Query\AbstractSelectQuery;

class WhereComponent extends AbstractComponent
{
    private $conditions = [];
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
        $this->conditions[] = [$column, $operator, $value];
    }

    /**
     * @param callable $nested
     */
    public function whereAny(callable $nested)
    {
        $newWhereComponent = new WhereComponent('or', $this->level+1);
        $nested($newWhereComponent);
        $this->conditions[] = $newWhereComponent;
    }

    /**
     * @param callable $nested
     */
    public function whereAll(callable $nested)
    {
        $newWhereComponent = new WhereComponent('and', $this->level+1);
        $nested($newWhereComponent);
        $this->conditions[] = $newWhereComponent;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        $ret = [];
        foreach ($this->conditions as $condition) {
            if (is_array($condition)) {
                $ret[] = $condition[2];
            }
            else if ($condition instanceof WhereComponent) {
                $ret = array_merge($ret, $condition->getParams());
            }
        }
        return $ret;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $ret = '';
        $combine = [];
        $formatter = $this->formatter();
        foreach ($this->conditions as $condition) {
           if ($condition instanceof WhereComponent) {
               $combine[] = (string)$condition->injectFormatter($formatter);
           }
           else {
               $combine[] = "{$condition[0]} {$condition[1]} ?";
           }
        }

        $type = $formatter->insertKeyword(" {$this->type} ");
        $ret .= implode($type, $combine);
        if (($this->level === 0) && ($ret)) {
            $ret = $formatter->insertKeyword(' where ') . $ret;
        }
        else if (count($this->conditions) > 0) {
            $ret = '(' . $ret . ')';
        }

        return $ret;
    }

}
