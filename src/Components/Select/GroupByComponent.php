<?php

namespace Ejacobs\Phequel\Components\Select;

use Ejacobs\Phequel\AbstractExpression;

class GroupByComponent extends AbstractExpression
{
    private $columns = [];

    /**
     * GroupByComponent constructor.
     * @param $columns
     */
    public function __construct($columns = [])
    {
        $this->addColumns($columns);
    }

    /**
     * @param $columns
     */
    public function addColumns($columns)
    {
        if (!is_array($columns)) {
            $columns = [$columns];
        }
        $this->columns = array_merge($this->columns, $columns);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (!$this->columns) {
            return '';
        }
        $formatter = $this->formatter();
        return $formatter->insert($formatter::type_block_keyword, 'group by')
            . $formatter->insert($formatter::type_columns, $this->columns)
            . $formatter->insert($formatter::type_end);
    }

}
