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
    private $indentation = "\t";
    private $indentColumns = false;
    private $initiated = false;
    private $interpolate = false;
    private $placeholder = '?';
    private $semicolonAtEnd = false;
    private $tableQuoteChar = '"';
    private $uppercase = true;

    const type_block_end = 1;
    const type_block_keyword = 2;
    const type_block_number = 3;
    const type_close_paren = 4;
    const type_column = 5;
    const type_columns = 6;
    const type_comma_separated = 7;
    const type_condition = 8;
    const type_indentation = 9;
    const type_keyword = 10;
    const type_on_clause = 11;
    const type_open_paren = 12;
    const type_operator = 13;
    const type_primary_keyword = 14;
    const type_query_ending = 15;
    const type_table = 17;
    const type_value = 18;
    const type_values = 19;
    const type_column_unquoted = 20;
    const type_function = 21;
    const type_alias = 22;

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
     * @param bool $newLine
     * @return string
     */
    public function insert($type, $value = null, $paren = false, $newLine = true)
    {
        switch ($type) {
            case self::type_primary_keyword:
                if (!$this->initiated) {
                    $this->initiated = true;
                    $ret = $this->keyword($value);
                } else {
                    $ret = "{$this->addIndent()}{$this->keyword($value)}";
                }
                $this->level++;
                return $ret;
            case self::type_block_keyword:
                $ret = "{$this->addIndent()}{$this->keyword($value)}";
                $ret .= $this->insert(self::type_indentation, null, $paren);
                return $ret;
            case self::type_keyword:
                if ($newLine) {
                    return "{$this->addIndent()}{$this->keyword($value)}";
                }
                return " {$this->keyword($value)}";
            case self::type_columns:
                if (!is_array($value)) {
                    $value = [$value];
                }
                $glue = "";
                $columns = [];
                foreach ($value as $column) {
                    $columns[] = $this->insert(self::type_column, $column);
                }
                return $this->insert(self::type_open_paren, null, $paren)
                    . $glue . implode(',' . $glue, $columns)
                    . $this->insert(self::type_close_paren, null, $paren);
            case self::type_block_end:
                $ret = '';
                $this->level--;
                if ($paren) {
                    $ret .= "{$this->addIndent()})";
                }
                return $ret;
            case self::type_condition:
                $ret = $this->addIndent();
                $ret .= " {$this->insert(self::type_column, $value[0], false, false)}";
                $ret .= " {$value[1]}";
                if (isset($value[2])) {
                    $ret .= " {$this->insert(self::type_value, $value[2])}";
                }
                return $ret;
            case self::type_indentation:
                $this->level++;
                if ($paren) {
                    return ' (';
                }
                return '';
            case self::type_table:
                if (!is_array($value)) {
                    $value = [$value];
                }
                if (is_string($value[1] ?? null)) {
                    return $this->addIndent()
                        . $this->enquote($this->tableQuoteChar, $value[0])
                        . ' ' . $this->keyword('as')
                        . ' ' . $this->enquote($this->tableQuoteChar, $value[1]);
                }
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
            case self::type_values:
                $parts = [];
                foreach ($value as $singleValue) {
                    $parts[] = [self::type_value, $singleValue, false];
                }
                return $this->insert(self::type_comma_separated, $parts, true);
            case self::type_operator:
                return ' =';
            case self::type_comma_separated:
                $strings = [];
                foreach ($value as $singleValue) {
                    if (is_array($singleValue)) {
                        $strings[] = $this->insert($singleValue[0], $singleValue[1], $singleValue[2]);
                    } else {
                        if ($singleValue instanceof AbstractExpression) {
                            $singleValue->format($this);
                        }
                        $strings[] = (string)$singleValue;
                    }
                }
                return $this->insert(self::type_open_paren, null, $paren)
                    . implode(',', $strings)
                    . $this->insert(self::type_close_paren, null, $paren);
            case self::type_open_paren:
                if ($paren) {
                    if ($value) {
                        return " (";
                    }
                    return "{$this->addIndent()}(";
                }
                return '';
            case self::type_close_paren:
                if ($paren) {
                    if ($newLine) {
                        return "{$this->addIndent()})";
                    }
                    return ')';
                }
                return '';
            case self::type_column:
                if (!is_array($value)) {
                    $value = [null, $value];
                }
                $ret = '';
                if ($newLine) {
                    $ret = $this->addIndent();
                }
                if (is_string($value[0] ?? null)) {
                    $ret .= $this->enquote($this->tableQuoteChar, $value[0]);
                    $ret .= '.';
                }
                $ret .= $this->enquote($this->tableQuoteChar, $value[1]);
                return $ret;
            case self::type_column_unquoted:
                if (!is_array($value)) {
                    $value = [null, $value];
                }
                $ret = '';
                if ($newLine) {
                    $ret = $this->addIndent();
                }
                if (is_string($value[0] ?? null)) {
                    $ret .= "{$value[0]}.";
                }
                $ret .= $value[1];
                return $ret;
            case self::type_query_ending:
                if ($this->semicolonAtEnd) {
                    return ';';
                }
                return '';
            case self::type_function:
                return "{$this->addIndent()}{$value[0]}("
                . $this->insert(self::type_column_unquoted, $value[1], false, false)
                . ')';
            case self::type_alias:
                if ($value === null) {
                    return '';
                }
                return ' ' . $this->keyword('as') . ' ' . $this->enquote($this->tableQuoteChar, $value);
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
     * @param bool $semicolonAtEnd
     * @return $this
     */
    public function semicolonAtEnd($semicolonAtEnd = true)
    {
        $this->semicolonAtEnd = $semicolonAtEnd;
        return $this;
    }

    /**
     * @param string $tableQuoteChar
     * @return $this
     */
    public function dialectSettings($tableQuoteChar)
    {
        $this->tableQuoteChar = $tableQuoteChar;
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
     * @param $char
     * @param $value
     * @param $isQuoted
     * @return string
     */
    private function enquote($char, $value, $isQuoted = true)
    {
        if ($isQuoted) {
            return "{$char}{$value}{$char}";
        }
        return "{$value}";
    }

    /**
     * @return string
     */
    function __toString()
    {
        return (string)$this->parentQuery;
    }

}