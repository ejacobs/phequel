<?php

namespace Ejacobs\Phequel\Components\Insert;

use Ejacobs\Phequel\AbstractExpression;

class ReturningComponent extends AbstractExpression
{
    private $column;
    private $alias;

    /**
     * ReturningComponent constructor.
     * @param string|null $column
     * @param string|null $alias
     */
    public function __construct($column = null, $alias = null)
    {
        $this->column = $column;
        $this->alias = $alias;
    }

    public function __toString()
    {
        if ($this->column) {
            $ret = $this->format()->insertKeyword(' returning ') . $this->column;
            if ($this->alias !== null) {
                $ret .= $this->format()->insertKeyword(' as ') . $this->alias;
            }
            return $ret;
        } else {
            return '';
        }
    }

}
