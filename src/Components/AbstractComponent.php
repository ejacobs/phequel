<?php

namespace Ejacobs\Phequel\Components;

use Ejacobs\Phequel\Formatter;

abstract class AbstractComponent
{
    /* @var Formatter $formatter */
    private $formatter;

    private $level;

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
     * @return Formatter
     * @throws \Exception
     */
    public function formatter()
    {
        if ($this->formatter instanceof Formatter) {
            return $this->formatter;
        }
        throw new \Exception('Formatter not set');
    }

    /**
     * @param Formatter $formatter
     * @param int $level
     * @return $this
     */
    public function injectFormatter(Formatter $formatter)
    {
        $this->formatter = $formatter;
        return $this;
    }

    /**
     * @param string|null $begin
     * @param array $components
     * @param string|null $end
     * @return string
     */
    public function compose($begin, array $components, $end = null)
    {
        $ret = '';
        $formatter = $this->formatter();
        foreach ($components as &$component) {
            if ($component instanceof AbstractComponent) {
                $component->injectFormatter($formatter);
            }
            $ret .= (string)$component;
        }
        if ($ret) {
            if ($begin) {
                $ret = $formatter->insertKeyword($begin) . $ret;
            }
            if ($end !== null) {
                $ret = $ret . $formatter->insertKeyword($end);
            }
        }
        return $ret;
    }

}
