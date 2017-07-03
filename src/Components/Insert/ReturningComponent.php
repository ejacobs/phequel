<?php

namespace Ejacobs\Phequel\Component\Insert;

use Ejacobs\Phequel\Component\AbstractComponent;

class ReturningComponent extends AbstractComponent
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
            $ret = " RETURNING {$this->column}";
            if ($this->alias !== null) {
                $ret .= " AS {$this->alias}";
            }
            return $ret;
        } else {
            return '';
        }
    }

}
