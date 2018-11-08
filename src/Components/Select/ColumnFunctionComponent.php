<?php

namespace Phion\Phequel\Components\Select;

use Phion\Phequel\AbstractExpression;
use Phion\Phequel\Format;

class ColumnFunctionComponent extends AbstractColumnComponent
{

    private $function;
    private $inputs;
    private $alias;

    /**
     * FunctionComponent constructor.
     * @param string $function
     * @param string|array|AbstractExpression $inputs
     * @param string|null $alias
     */
    public function __construct($function, $inputs = null, $alias = null)
    {
        $this->function = $function;
        $this->inputs = $inputs;
        $this->alias = $alias;

    }

    /**
     * @return string
     */
    public function toString()
    {
        $components = [];
        $components[] = [Format::type_raw, $this->function];
        $components[] = [Format::type_open_paren, null, Format::spacing_no_space];
        if ($this->inputs !== null) {
            if ($this->inputs instanceof AbstractExpression) {
                $components[] = $this->inputs;
            }
            else if (is_array($this->inputs)) {
                $components[] = [Format::type_column, $this->inputs, Format::spacing_no_space];
            }
            else {
                $components[] = [Format::type_raw, $this->inputs, Format::spacing_no_space];
            }
        }
        $components[] = [Format::type_close_paren, null, Format::spacing_no_space];
        $components[] = [Format::type_alias, $this->alias];
        return $this->compose(true, $components);
    }

}
