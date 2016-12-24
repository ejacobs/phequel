<?php

namespace Ejacobs\QueryBuilder\Component;


class WhereComponent extends AbstractComponent
{
    private $expression;
    private $params;

    /**
     * WhereComponent constructor.
     * @param $expression
     * @param $params
     */
    public function __construct($expression, $params = [])
    {
        $this->expression = $expression;
        if (!is_array($params)) {
            $params = [$params];
        }
        $this->params = $params;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function __toString()
    {
        return "({$this->expression})";
    }

}
