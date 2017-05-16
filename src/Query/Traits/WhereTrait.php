<?php

namespace Ejacobs\Phequel\Query\Traits;

use Ejacobs\Phequel\Component\WhereComponent;

/**
 * Class WhereTrait
 * @package Ejacobs\Phequel\Query\Traits
 */
trait WhereTrait
{

    /**
     * @param $column
     * @param $operator
     * @param $param
     * @return $this
     */
    public function where($column, $operator = null, $param = null)
    {
        if ($param !== null) {
            $param = $this->escapeWildcards($param);
        }
        $this->whereComponent->where($column, $operator, $param);
        return $this;
    }

    /**
     * @param callable $nested
     * @return $this
     */
    public function whereAny(callable $nested)
    {
        $this->whereComponent->whereAny($nested);
        return $this;
    }


    /**
     * @param callable $nested
     * @return $this
     */
    public function whereAll(callable $nested)
    {
        $this->whereComponent->whereAll($nested);
        return $this;
    }

}