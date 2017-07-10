<?php

namespace Ejacobs\Phequel\Components\Select;

use Ejacobs\Phequel\Components\AbstractComponent;
use Ejacobs\Phequel\Components\ColumnComponent;

class WindowComponent extends AbstractComponent
{
    private $windows = [];

    /**
     * WindowComponent constructor.
     * @param array $windows
     */
    public function __construct($windows = [])
    {
        $this->windows = $windows;
    }

    /**
     * @param $alias
     * @param $statement
     */
    public function addWindow($alias, $statement)
    {
        $this->windows[$alias] = $statement;
    }

    /**
     * @param string[] $columns
     */
    public function addWindows($columns)
    {
       foreach ($columns as $alias => $statement) {
           $this->addWindow($alias, $statement);
       }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (!$this->windows) {
            return '';
        }
        $formatter = $this->formatter();
        $ret = $formatter->insert($formatter::type_block_keyword, 'window');
        foreach ($this->windows as $alias => $window) {
            $ret .= $formatter->insert($formatter::type_columns, [$alias]);
            $ret .= $formatter->insert($formatter::type_keyword, 'AS');
            $ret .= $formatter->insert($formatter::type_statement, $window, true);
        }
        $ret .= $formatter->insert($formatter::type_end);
        return $ret;
    }

}
