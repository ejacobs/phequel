<?php

namespace Ejacobs\Phequel\Query\Traits;

use Ejacobs\Phequel\Components\WhereComponent;

/**
 * Class WhereTrait
 * @package Ejacobs\Phequel\Query\Traits
 */
trait WhereTrait
{

    /* @var WhereComponent $whereComponent */
    protected $whereComponent;

    /**
     * @param $column
     * @param null $operator
     * @param null $param
     * @return $this
     */
    public function where($column, $operator = null, $param = null)
    {
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