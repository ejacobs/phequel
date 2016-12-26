<?php

namespace Ejacobs\QueryBuilder\Component;


class WhereComponent extends AbstractComponent
{
    private $components;
    private $params = [];
    private $type;
    private $validTypes = ['and', 'or'];

    /**
     * WhereComponent constructor.
     * @param $components
     * @param array $params
     * @param string $type
     * @throws \Exception
     */
    public function __construct($components, $params = [], $type = 'and')
    {
        if (in_array(strtolower($type), $this->validTypes)) {
            $this->type = strtoupper($type);
        }
        else {
            throw new \Exception("Where conditions type must be one of the following: " . implode(', ', $this->validTypes));
        }

        if (!is_array($components)) {
            $components = [$components];
        }

        if (!is_array($params)) {
            $params = [$params];
        }

        foreach ($components as $component) {
            if (is_string($component)) {
                $this->params = $params;
            }
            else if ($component instanceof WhereComponent) {
                $this->params = array_merge($this->params, $component->getParams());
            }
        }

        $this->components = $components;
    }

    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return '(' . implode(" {$this->type} ", $this->components) . ')';
    }

}
