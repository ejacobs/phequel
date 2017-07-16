<?php

namespace Ejacobs\Phequel\Components\Select;

use Ejacobs\Phequel\AbstractExpression;

class OffsetComponent extends AbstractExpression
{
    private $offset;

    /**
     * SelectComponent constructor.
     * @param int|null $offset
     */
    public function __construct($offset = null)
    {
        $this->offset = $offset;
    }

    public function __toString()
    {
        if ($this->offset === null) {
            return '';
        }
        $formatter = $this->formatter();
        return $formatter->insert($formatter::type_block_keyword, 'offset')
            . $formatter->insert($formatter::type_block_number, $this->offset)
            . $formatter->insert($formatter::type_end);
    }

}
