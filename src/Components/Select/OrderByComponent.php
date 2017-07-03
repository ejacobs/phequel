<?php

namespace Ejacobs\Phequel\Components\Select;

use Ejacobs\Phequel\Components\AbstractComponent;

class OrderByComponent extends AbstractComponent
{
    private $column;
    private $direction;

    /**
     * OffsetComponent constructor.
     * @param $column
     * @param string $direction
     */
    public function __construct($column = null, $direction = 'asc')
    {
        $this->column = $column;
        $this->direction = $direction;
    }

    public function __toString()
    {
        if ($this->column) {
            $formatter = $this->formatter();
            return $formatter->insertKeyword(' order by ')
                . $this->column
                . $formatter->insertKeyword(" {$this->direction}");
        } else {
            return '';
        }
    }

}
