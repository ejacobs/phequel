<?php

namespace Ejacobs\Phequel\Component;

class WhereComponent extends AbstractComponent
{
    private $column;
    private $operator;
    private $value;
    private $components = [];
    private $type;
    private $level = 0;

    const valid_types = ['and', 'or'];

    /**
     * WhereComponent constructor.
     * @param null $column
     * @param null $operator
     * @param null $value
     * @param string $type
     * @throws \Exception
     */
    public function __construct($column = null, $operator = null, $value = null, $type = 'and')
    {
        if (in_array(strtolower($type), self::valid_types)) {
            $this->type = strtoupper($type);
        } else {
            throw new \Exception("Where conditions type must be one of the following: " . implode(', ', self::valid_types));
        }

        $this->column = $column;
        $this->operator = $operator;
        $this->value = $value;
    }

    /**
     * @param WhereComponent $component
     */
    public function addCondition(WhereComponent $component)
    {
        $component->setLevel($this->level + 1);
        $this->components[] = $component;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        $ret = [];
        if ($this->operator) {
            $ret[] = $this->value;
        }
        foreach ($this->components as $component) {
            foreach ($component->getParams() as $param) {
                $ret[] = $param;
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

        if ($this->level === 0) {
            if ($this->column || $this->components) {
                $ret .= ' WHERE ';
            }
        }

        if ($this->column && $this->operator && $this->value) {
            $ret .= "{$this->column} {$this->operator} ?";
        }

        if ($this->components) {

            $useParens = (($this->level !== 0) && (count($this->components) > 1));

            if ($useParens) {
                $ret .= '(';
            }

            $ret .= implode(" {$this->type} ", $this->components);

            if ($useParens) {
                $ret .= ')';
            }
        }
        return $ret;
    }

    /**
     * @param int $level
     */
    protected function setLevel($level)
    {
        $this->level = $level;
    }

}
