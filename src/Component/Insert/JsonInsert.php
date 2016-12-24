<?php

namespace Ejacobs\QueryBuilder\Component\Insert;

use Ejacobs\QueryBuilder\Component\SelectComponent;

class JsonInsert extends SelectComponent
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
     * @param $property
     * @param $raw
     * @return $this
     */
    public function narrow($property, $raw = false)
    {
        $this->narrows[] = [$property, $raw];
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
