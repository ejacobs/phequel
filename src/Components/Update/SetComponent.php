<?php

namespace Ejacobs\Phequel\Components\Update;

use Ejacobs\Phequel\AbstractExpression;

class SetComponent extends AbstractExpression
{
    private $values;

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
        if ($this->values) {
            $setParts = [];
            foreach ($this->values as $column => $value) {
                $setParts[] = "{$column} = ?";
            }
            return $this->format()->insertKeyword(' set ') . implode(', ', $setParts);
        }
        return '';
    }

}
