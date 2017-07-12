<?php

namespace Ejacobs\Phequel\Query;

abstract class AbstractUnionIntersectQuery extends AbstractQuery
{

    /* @var AbstractSelectQuery[] $selectQueries */
    protected $selectQueries = [];

    abstract public function union($tableName, $all = false);

    abstract public function intersect($tableName);

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
    }

    /**
     * @param string $type
     * @param AbstractSelectQuery $query
     * @return AbstractSelectQuery
     */
    protected function add($type, AbstractSelectQuery $query)
    {
        $this->selectQueries[] = [$type, $query];
        return $query;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        $params = [];
        foreach ($this->selectQueries as $query) {
            $params = array_merge($params, $query->getParams());
        }
        return $params;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $ret = '';
        $formatter = $this->formatter();
        $first = true;
        foreach ($this->selectQueries as $queryArr) {
            if (!$first) {
                $ret .= $formatter->insert($formatter::type_keyword, $queryArr[0]);
            }
            $first = false;
            $ret .= (string)$queryArr[1];
        }
        return $ret;
    }

}