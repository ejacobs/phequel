<?php

namespace Phion\Phequel\Components\Update;

use Phion\Phequel\AbstractExpression;
use Phion\Phequel\Format;

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
    public function toString()
    {
        $components = [];
        $components[] = [Format::type_block_keyword, 'set'];
        end($this->values);
        $lastKey = key($this->values);
        foreach ($this->values as $column => $value) {
            $components[] = [Format::type_column, $column];
            $components[] = [Format::type_operator, '=', Format::spacing_no_indent];
            $components[] = [Format::type_value, $value, Format::spacing_no_indent];
            if ($column !== $lastKey) {
                $components[] = [Format::type_raw, ',', Format::spacing_no_space];
            }
        }
        $components[] = [Format::type_block_end];
        return $this->compose((bool)$this->values, $components);
    }

}
