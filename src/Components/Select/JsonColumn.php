<?php

namespace Ejacobs\Phequel\Components\Select;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Format;

class JsonColumn extends AbstractExpression
{

    protected $narrows = [];
    protected $column;
    protected $alias;

    /**
     * JsonColumn constructor.
     * @param string $column
     * @param string|null $alias
     */
    public function __construct($column, $alias = null)
    {
        $this->column = $column;
        $this->alias = $alias;
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
        $narrowStr = '';
        foreach ($this->narrows as $narrow) {
            if ($narrow[1]) {
                $narrowStr .= '->>';
            } else {
                $narrowStr .= '->';
            }
            $narrowStr .= "'{$narrow[0]}'";
        }
        return $this->compose(true, [
            [Format::type_column, $this->column],
            [Format::type_raw, $narrowStr],
            [Format::type_alias, $this->alias]
        ]);
    }

}
