<?php

namespace Ejacobs\Phequel\Components\Select;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Format;

/**
 * Class FromRawComponent
 * @package Ejacobs\Phequel\Components\Select
 */
class FromRawComponent extends AbstractExpression
{
    /* @var string $raw */
    private $raw;

    /* @var null|string $alias */
    private $alias;

    /**
     * FromComponent constructor.
     * @param string $raw
     * @param null|string $alias
     */
    public function __construct($raw = null, $alias = null)
    {
        $this->raw = $raw;
        $this->alias = $alias;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->compose(true, [
            [Format::type_block_keyword, 'from'],
            [Format::type_raw, $this->raw],
            [Format::type_alias, $this->alias],
            [Format::type_block_end]
        ]);
    }

}
