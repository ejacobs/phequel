<?php

namespace Ejacobs\QueryBuilder\Query;

use Ejacobs\QueryBuilder\Component\SetComponent;
use Ejacobs\QueryBuilder\Component\WhereComponent;

class AbstractUpdateQuery extends AbstractBaseQuery
{

    /* @var SetComponent[] $setComponents */
    protected $setComponents = [];

    /* @var WhereComponent[] $whereComponents */
    protected $whereComponents = [];

    /**
     * @param string $column
     * @param string $value
     * @return $this
     */
    public function set($column, $value)
    {
        $this->setComponents[] = new SetComponent($column, $value);
        return $this;
    }

    /**
     * @param array $values
     * @return $this
     */
    public function setMultiple($values)
    {
        foreach ($values as $column => $value) {
            $this->setComponents[] = new SetComponent($column, $value);
        }
        return $this;
    }

    /**
     * @param $expression
     * @param array $params
     * @return $this
     */
    public function where($expression, $params = [])
    {
        $this->whereComponents[] = new WhereComponent($expression, $params);
        return $this;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        $params = [];
        foreach ($this->setComponents as $setComponent) {
            $params = array_merge($params, $setComponent->getParams());
        }
        foreach ($this->whereComponents as $whereComponent) {
            $params = array_merge($params, $whereComponent->getParams());
        }
        return $params;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $ret = 'UPDATE ' . $this->tableComponent . ' ';
        $ret .= 'SET ' . implode(', ', $this->setComponents) . ' ';
        if ($this->whereComponents) {
            $ret .= 'WHERE ' . implode(', ', $this->whereComponents) . ' ';
        }
        return $ret;
    }


}