<?php

namespace Ejacobs\Phequel\Components\Select;

use Ejacobs\Phequel\Components\AbstractComponent;

class SelectComponent extends AbstractComponent
{
    private $columns = [];
    private $defaultSelectAll = false;
    private $distinct = false;
    private $distinctOn = null;

    /**
     * Select all columns (*) by default, unless explicitly specified
     *
     * SelectComponent constructor.
     * @param string $columns
     */
    public function __construct($columns = '*')
    {
        if ($columns === '*') {
            $this->defaultSelectAll = true;
            $this->columns = ['*'];
        }
    }

    /**
     * @param $columns
     * @param bool $clear
     */
    public function addColumns($columns, $clear = false)
    {
        if ($this->defaultSelectAll || $clear) {
            $this->columns = [];
            $this->defaultSelectAll = false;
        }
        if (!is_array($columns)) {
            $columns = [$columns];
        }
        $this->columns = array_merge($this->columns, $columns);
        $this->columns = array_unique($this->columns);
    }

    /**
     * @param bool $distinct
     * @param null $on
     */
    public function setDistinct($distinct = true, $on = null)
    {
        $this->distinct = $distinct;
        $this->distinctOn = $on;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $ret = $this->formatter()->insertKeyword('select') . ' ';
        if ($this->distinct) {
            $ret .= $this->formatter()->insertKeyword('distinct') . ' ';
            if ($this->distinctOn !== null) {
                $ret .=  $this->formatter()->insertKeyword('on') . ' (' . $this->distinctOn . ') ';
            }
        }
        $ret .= implode(', ', $this->columns);
        $ret .= ' ' . $this->formatter()->insertKeyword('from');
        return $ret;
    }

}
