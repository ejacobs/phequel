<?php

namespace Phion\Phequel\Components\Select;

use Phion\Phequel\AbstractExpression;
use Phion\Phequel\Format;

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
    public function toString()
    {
        return $this->compose(!!$this->limit, [
            [Format::type_block_keyword, 'limit'],
            [Format::type_block_number, $this->limit],
            [Format::type_block_end]
        ]);
    }

}
