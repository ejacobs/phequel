<?php

namespace Ejacobs\Phequel\Component;

class WhereComponent extends AbstractComponent
{
    private $type;
    private $level = 0;

    private $conditions = [];

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
        if (in_array(strtolower($type), self::valid_types)) {
            $this->type = strtoupper($type);
        } else {
            throw new \Exception("Where conditions type must be one of the following: " . implode(', ', self::valid_types));
        }
    }

    /**
     * @param $column
     * @param $operator
     * @param $value
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
        foreach ($this->conditions as $condition) {
           if (!is_object($condition)) {
               $combine[] = "{$condition[0]} {$condition[1]} ?";
           }
           else {
               $combine[] = (string)$condition;
           }
        }

        $ret .= implode(" {$this->type} ", $combine);

        if (($this->level === 0) && ($ret)) {
            $ret = ' WHERE ' . $ret;
        }
        else if (count($this->conditions) > 0) {
            $ret = '(' . $ret . ')';
        }

        return $ret;
    }


}
