<?php

namespace Ejacobs\Phequel\Components\Select;

use Ejacobs\Phequel\AbstractExpression;

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
        if ($this->count === null) {
            return '';
        }
        $formatter = $this->format();
        return $formatter->insert($formatter::type_block_keyword, 'fetch')
            . $formatter->insert($formatter::type_keyword, $this->firstNext)
            . $formatter->insert($formatter::type_block_number, $this->count)
            . $formatter->insert($formatter::type_keyword, 'only')
            . $formatter->insert($formatter::type_block_end);
    }

}
