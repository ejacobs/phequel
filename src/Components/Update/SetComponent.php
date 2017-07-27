<?php

namespace Ejacobs\Phequel\Components\Update;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Format;

class SetComponent extends AbstractExpression
{
    private $values = [];

    /**
     * @param string $column
     * @param string $value
     */
    public function setValue($column, $value)
    {
        $this->values[$column] = $value;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return array_values($this->values);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $components = [];
        $components[] = [Format::type_block_keyword, 'set'];
        $setStatements = [];
        foreach ($this->values as $column => $value) {
            $setStatements[] = [Format::type_condition, [$column, '=', $value], false];
        }
        $components[] = [Format::type_comma_separated, $setStatements];
        $components[] = [Format::type_block_end];
        return $this->compose(!!$this->values, $components);
    }

}
