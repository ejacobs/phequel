<?php

namespace Ejacobs\Phequel\Components\Select;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Format;

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

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->compose(!!$this->limit, [
            [Format::type_block_keyword, 'limit'],
            [Format::type_block_number, $this->limit],
            [Format::type_block_end]
        ]);
    }

}
