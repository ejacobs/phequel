<?php

namespace Ejacobs\Phequel\Components\Select;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Components\NumberComponent;

class LimitComponent extends AbstractExpression
{
    private $limit;

    /**
     * LimitComponent constructor.
     * @param int|null $limit
     */
    public function __construct($limit = null)
    {
        $this->limit = $limit;
    }

    public function __toString()
    {
        if ($this->limit === null) {
            return '';
        }
        $formatter = $this->format();
        return $formatter->insert($formatter::type_block_keyword, 'limit')
            . $formatter->insert($formatter::type_block_number, $this->limit)
            . $formatter->insert($formatter::type_block_end);
    }

}
