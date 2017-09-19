<?php

namespace Ejacobs\Phequel\Components\Insert;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Format;

class RowComponent extends AbstractExpression
{
    private $values = [];
    private $sortedValues = [];

    /**
     * RowsComponent constructor.
     * @param array $values
     */
    public function __construct(array $values)
    {
        $this->values = $values;
    }

    /**
     * Sort the values for this row to match the ordering of the given columns
     * @param array $columns
     */
    public function sortValues(array $columns)
    {
        $this->sortedValues = [];
        foreach ($columns as $column) {
            $this->sortedValues[] = $this->values[$column] ?? null;
        }
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->sortedValues;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->compose(true, [
            [Format::type_open_paren, null, Format::spacing_no_space],
            [Format::type_values, $this->sortedValues, Format::spacing_no_indent],
            [Format::type_close_paren, null, Format::spacing_no_space]
        ]);
    }

}
