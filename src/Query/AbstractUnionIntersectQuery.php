<?php

namespace Ejacobs\Phequel\Query;

use Ejacobs\Phequel\AbstractExpression;

abstract class AbstractUnionIntersectQuery extends AbstractBaseQuery
{

    /* @var AbstractExpression[] $expressions */
    protected $expressions = [];

    /**
     * @param $tableName
     * @return mixed
     */
    abstract public function intersect($tableName);

    /**
     * @param $tableName
     * @param bool $all
     * @return mixed
     */
    abstract public function union($tableName, $all = false);

    /**
     * AbstractUnionIntersectQuery constructor.
     * @param null|callable $nested
     * @throws \Exception
     */
    public function __construct(callable $nested = null)
    {
        if ($nested !== null) {
            $nested($this);
        }
        parent::__construct();
    }

    /**
     * @param AbstractExpression $unionOrIntersect
     * @param AbstractSelectQuery $query
     * @return AbstractSelectQuery
     */
    protected function add(AbstractExpression $unionOrIntersect, AbstractSelectQuery $query)
    {
        if ($this->expressions) {
            $this->expressions[] = $unionOrIntersect;
            $this->expressions[] = $query;
        }
        else {
            $this->expressions[] = $query;
        }
        return $query;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        $params = [];
        foreach ($this->expressions as $expression) {
            $params = array_merge($params, $expression->getParams());
        }
        return $params;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->compose(true, [$this->expressions]);
    }

}