<?php

namespace Ejacobs\Phequel\Components\Select;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Format;

class FetchComponent extends AbstractExpression
{
    private $firstNext = null;
    private $count = null;

    const valid_first_next = ['first', 'next'];

    public function setFetch($firstNext, $count)
    {
        if (($firstNext !== null) && !in_array(strtolower($firstNext), self::valid_first_next)) {
            throw new \Exception("firstNext must be one of the following: " . implode(', ', self::valid_first_next));
        }
        $this->firstNext = $firstNext;
        $this->count = $count;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->compose(!!$this->count, [
            [Format::type_block_keyword, 'fetch'],
            [Format::type_keyword, $this->firstNext],
            [Format::type_block_number, $this->count],
            [Format::type_keyword,'only'],
            [Format::type_block_end]
        ]);
    }

}
