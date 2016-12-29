<?php

namespace Ejacobs\QueryBuilder\Component;


class WhereComponent extends AbstractComponent
{
    private $components = [];
    private $params = [];
    private $type;
    private $validTypes = ['and', 'or'];
    protected $level = 0;

    /**
     * WhereComponent constructor.
     * @param $components
     * @param array $params
     * @param string $type
     * @throws \Exception
     */
    public function __construct($components = [], $params = [], $type = 'and')
    {
        if (in_array(strtolower($type), $this->validTypes)) {
            $this->type = strtoupper($type);
        } else {
            throw new \Exception("Where conditions type must be one of the following: " . implode(', ', $this->validTypes));
        }

        $this->addConditions($components, $params);
    }

    /**
     * @param $components
     * @param array $params
     */
    public function addConditions($components, $params = [])
    {
        if (!is_array($components)) {
            $components = [$components];
        }

        if (!is_array($params)) {
            $params = [$params];
        }

        foreach ($components as $component) {
            if (is_string($component)) {
                $this->params = $params;
            } else if ($component instanceof WhereComponent) {
                $component->setLevel($this->level + 1);
                $this->params = array_merge($this->params, $component->getParams());
            }
        }

        $this->components = array_merge($this->components, $components);
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $ret = '';
        if ($this->components) {

            if ($this->level === 0) {
                $ret .= ' WHERE ';
            }

            $useParens = (($this->level !== 0) && (count($this->components) > 1));

            if ($useParens) {
                $ret .= '(';
            }

            $ret .= implode(" {$this->type} ", $this->components);

            if ($useParens) {
                $ret .= ')';
            }
        }
        return $ret;
    }

    protected function setLevel($level)
    {
        $this->level = $level;
    }

}
