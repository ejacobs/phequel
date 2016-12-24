<?php

namespace Ejacobs\QueryBuilder\Component\Select;

use Ejacobs\QueryBuilder\Component\SelectComponent;

class JsonSelect extends SelectComponent
{

    protected $narrows = [];
    protected $column;

    /**
     * SelectComponent constructor.
     * @param string $column
     */
    public function __construct($column)
    {
        $this->column = $column;
    }

    /**
     * @param $column
     * @param null $alias
     * @return static
     */
    public static function create($column, $alias = null)
    {
        return new static($column, $alias);
    }

    /**
     * @param string $property
     * @param bool $text
     * @return $this
     */
    public function narrow($property, $text = false)
    {
        $this->narrows[] = [$property, $text];
        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $ret = $this->column;
        foreach ($this->narrows as $narrow) {
            if ($narrow[1]) {
                $ret .= '->>';
            } else {
                $ret .= '->';
            }
            $ret .= "'{$narrow[0]}'";
        }
        return $ret;
    }

}
