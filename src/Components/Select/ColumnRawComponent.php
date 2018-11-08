<?php

namespace Phion\Phequel\Components\Select;

use Phion\Phequel\Format;

class ColumnRawComponent extends AbstractColumnComponent
{

    private $value;
    private $alias;

    /**
     * ColumnRawComponent constructor.
     * @param $value
     * @param $alias
     */
    public function __construct($value, $alias = null)
    {
        $this->value = $value;
        $this->alias = $alias;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->compose(true, [
            [Format::type_raw, $this->value],
            [Format::type_alias, $this->alias],
        ]);
    }

}
