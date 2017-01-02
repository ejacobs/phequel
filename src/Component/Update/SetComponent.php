<?php

namespace Ejacobs\QueryBuilder\Component\Update;

use Ejacobs\QueryBuilder\Component\AbstractComponent;

class SetComponent extends AbstractComponent
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
            return ' SET ' . implode(', ', $setParts);
        }
        return '';
    }

}
