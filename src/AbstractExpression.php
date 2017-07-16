<?php

namespace Ejacobs\Phequel;

abstract class AbstractExpression
{
    /* @var Formatter $formatter */
    private $formatter;

    /**
     * @return string
     */
    abstract public function __toString();

    /**
     * @return array
     */
    public function getParams()
    {
        return [];
    }

    /**
     * @param Formatter|null $formatter
     * @return Formatter
     * @throws \Exception
     */
    public function formatter(Formatter $formatter = null)
    {
        if ($formatter instanceof Formatter) {
            return $this->formatter = $formatter;
        }
        elseif ($this->formatter instanceof Formatter) {
            return $this->formatter;
        }
        else {
            return $this->formatter = new Formatter($this);
        }
    }

    /**
     * @param $continue
     * @param array $components
     * @return string
     */
    protected function compose($continue, array $components)
    {
        if (!$continue) {
            return '';
        }
        $ret = '';
        $formatter = $this->formatter();
        foreach ($components as &$component) {
            if ($component instanceof AbstractExpression) {
                $component->formatter($formatter);
                $ret .= (string)$component;
            }
            else if (is_array($component)) {
                $ret .= $formatter->insert($component[0], $component[1] ?? null, $component[2] ?? null);
            }
        }
        return $ret;
    }

}
