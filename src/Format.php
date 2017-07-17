<?php

namespace Ejacobs\Phequel;

use Ejacobs\Phequel\Connector\AbstractConnector;

class Format
{

    /* @var AbstractConnector $connector */
    private $connector;

    /* @var int $level */
    private $level = 0;

    /* @var int $numericPlaceholderCounter */
    private $numericPlaceholderCounter = 1;

    /* @var AbstractExpression $connector */
    private $parentQuery;

    private $indent = false;
    private $uppercase = true;
    private $indentColumns = false;
    private $placeholder = '?';
    private $indentation = "\t";
    private $interpolate = false;
    private $newlineAtEnd = false;
    private $semicolonAtEnd = false;

    private $initiated = false;

    const type_primary_keyword = 0;
    const type_block_keyword = 1;
    const type_keyword = 2;
    const type_columns = 3;
    const type_block_end = 4;
    const type_statement = 5;
    const type_condition = 8;
    const type_indentation = 9;
    const type_table = 10;
    const type_on_clause = 11;
    const type_block_number = 12;
    const type_value = 13;

    /**
     * Format constructor.
     * @param AbstractExpression $parentQuery
     */
    public function __construct(AbstractExpression $parentQuery)
    {
        $this->parentQuery = $parentQuery;
    }

    /**
     * @param $type
     * @param null $value
     * @param bool $paren
     * @return mixed|string
     */
    public function insert($type, $value = null, $paren = false)
    {
        switch ($type) {
            case self::type_primary_keyword:
                if (!$this->initiated) {
                    $this->initiated = true;
                    $ret = $this->keyword($value);
                }
                else {
                    $ret = "{$this->addIndent()}{$this->keyword($value)}";
                }
                $this->level++;
                return $ret;
            case self::type_block_keyword:
                $ret = "{$this->addIndent()}{$this->keyword($value)}";
                $ret .= $this->insert(self::type_indentation, null, $paren);
                return $ret;
            case self::type_keyword:
                $ret = "{$this->addIndent()}{$this->keyword($value)}";
                if ($paren) {
                    $ret .= " (";
                }
                return $ret;
            case self::type_columns:
                if (!is_array($value)) {
                    $value = [$value];
                }
                $glue = "{$this->addIndent()}";
                return $glue . implode("," . $glue, $value);
            case self::type_block_end:
                $ret = '';
                $this->level--;
                if ($paren) {
                    $ret .= "{$this->addIndent()})";
                }
                return $ret;
            case self::type_statement:
                if ($paren) {
                    return "{$this->addIndent()}({$value})";
                } else {
                    return "{$this->addIndent()}{$value}";
                }
            case self::type_condition:
                return "{$this->addIndent()}{$value[0]} {$value[1]} {$this->insert(self::type_value, $value[2])}";
            case self::type_indentation:
                $this->level++;
                if ($paren) {
                    return ' (';
                }
                return '';
            case self::type_table:
                return "{$this->addIndent()}{$value}";
            case self::type_on_clause:
                return "{$this->addIndent()}{$value[0]} {$value[1]} {$value[2]}";
            case self::type_block_number:
                return "{$this->addIndent()}{$value}";
            case self::type_value:
                if ($this->interpolate) {
                    return $this->connector->escape($value);
                } else {
                    return str_replace('#', $this->numericPlaceholderCounter++, $this->placeholder);
                }
        }
        return '';
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
     * @param bool $interpolate
     * @return $this
     */
    public function interpolate(AbstractConnector $connector, $interpolate = true)
    {
        $this->connector = $connector;
        $this->interpolate = $interpolate;
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
     * @return string
     */
    private function addIndent()
    {
        if ($this->indent) {
            return "\n" . str_repeat($this->indentation, $this->level);
        } else {
            return ' ';
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