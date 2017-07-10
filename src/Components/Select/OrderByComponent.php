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
    public function __construct($column = null, $direction = null)
    {
        $this->column = $column;
        $this->direction = $direction;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->column === null) {
            return '';
        }
        $formatter = $this->formatter();
        $ret = $formatter->insert($formatter::type_block_keyword, 'order by')
            . $formatter->insert($formatter::type_columns, [$this->column]);
        if ($this->direction !== null) {
            $ret .= $formatter->insert($formatter::type_keyword, $this->direction);
        }
        $ret .= $formatter->insert($formatter::type_end);
        return $ret;
    }

}
