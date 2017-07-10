<?php

namespace Ejacobs\Phequel;

use Ejacobs\Phequel\Components\AbstractComponent;
use Ejacobs\Phequel\Connector\AbstractConnector;
use Ejacobs\Phequel\Query\AbstractQuery;

class Formatter
{
    /* @var int $level */
    public $level = 0;

    /* @var AbstractQuery $connector */
    private $parentQuery;

    /* @var AbstractConnector $connector */
    private $connector;

    /* @var int $numericPlaceholderCounter */
    private $numericPlaceholderCounter = 1;

    private $indent = false;
    private $uppercase = true;
    private $indentColumns = false;
    private $placeholder = '?';
    private $indentation = "\t";
    private $interpolate = false;

    const type_block_keyword = 1;
    const type_keyword = 2;
    const type_columns = 3;
    const type_end = 4;
    const type_statement = 5;
    const type_condition = 8;
    const type_indentation = 9;
    const type_table = 10;
    const type_on_clause = 11;
    const type_block_number = 12;

    /**
     * Formatter constructor.
     * @param AbstractQuery $parentQuery
     */
    public function __construct(AbstractQuery $parentQuery)
    {
        $this->parentQuery = $parentQuery;
    }

    public function insert($type, $value = null, $paren = false)
    {
        switch ($type) {
            case self::type_block_keyword:
                $ret = "\n{$this->addIndent()}{$this->keyword($value)}";
                $ret .= $this->insert(self::type_indentation, null, $paren);
                return $ret;
            case self::type_keyword:
                $ret = "\n{$this->addIndent()}{$this->keyword($value)}";
                if ($paren) {
                    $ret .= " (";
                }
                return $ret;
            case self::type_columns:
                $glue = "\n{$this->addIndent()}";
                return $glue . implode("," . $glue, $value);
            case self::type_end:
                $ret = '';
                $this->level--;
                if ($paren) {
                    $ret .= "\n{$this->addIndent()})";
                }
                return $ret;
            case self::type_statement:
                if ($paren) {
                    return "\n{$this->addIndent()}({$value})";
                }
                else {
                    return "\n{$this->addIndent()}{$value}";
                }
            case self::type_condition:
                return "\n{$this->addIndent()}{$value[0]} {$value[1]} {$this->placeholder($value[2])}";
            case self::type_indentation:
                $this->level++;
                if ($paren) {
                    return ' (';
                }
                return '';
            case self::type_table:
                return " {$value}";
            case self::type_on_clause:
                return "\n{$this->addIndent()}{$value[0]} {$value[1]} {$value[2]}";
            case self::type_block_number:
                return "\n{$this->addIndent()}{$value}";
        }
        return '';
    }

    private function addIndent($adjust = 0)
    {
        $level = $this->level;
        $this->level += $adjust;
        return str_repeat("  ", $level);
    }

    /**
     * @param AbstractComponent[] $components
     * @return string
     */
    public function compose(array $components)
    {
        $ret = '';
        foreach ($components as $component) {
            if ($component instanceof AbstractComponent) {
                $ret .= (string)$component->injectFormatter($this);
            }
        }
        return $ret . ";\n";
    }

    /**
     * @param bool $indent
     * @return $this
     */
    public function indent($indent = true)
    {
        $this->indent = $indent;
        return $this;
    }

    /**
     * @param bool $indent
     * @return $this
     */
    public function indentColumns($indent = true)
    {
        $this->indentColumns = $indent;
        return $this;
    }

    /**
     * @return $this
     */
    public function useTabs()
    {
        $this->indentation = "\t";
        return $this;
    }

    /**
     * @param int $numberOfSpaces
     * @return $this
     */
    public function useSpaces($numberOfSpaces = 4)
    {
        $this->indentation = str_repeat(' ', $numberOfSpaces);
        return $this;
    }

    /**
     * @param bool $uppercase
     * @return $this
     */
    public function uppercaseKeywords($uppercase = true)
    {
        $this->uppercase = $uppercase;
        return $this;
    }


    /**
     * @param string $type
     * @return $this
     */
    public function placeholderType($type = '?')
    {
        $this->placeholder = $type;
        return $this;
    }

    /**
     * WARNING: Query value interpolation is potentially dangerous and should not be used on production. It exists as a
     * tool to assist developers when debugging queries.
     *
     * @param AbstractConnector $connector
     * @return $this
     */
    public function interpolate(AbstractConnector $connector)
    {
        $this->connector = $connector;
        $this->interpolate = true;
        return $this;
    }


    /**
     * @param string $keyword
     * @return string
     */
    private function keyword($keyword)
    {
        if ($this->uppercase) {
            return strtoupper($keyword);
        } else {
            return strtolower($keyword);
        }
    }


    /**
     * @param $value
     * @return string
     */
    private function placeholder($value)
    {
        if ($this->interpolate) {
            return $this->connector->escape($value);
        } else {
            return str_replace('#', $this->numericPlaceholderCounter++, $this->placeholder);
        }
    }


    /**
     * @return string
     */
    function __toString()
    {
        return (string)$this->parentQuery;
    }

}