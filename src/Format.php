<?php

namespace Ejacobs\Phequel;

use Ejacobs\Phequel\Connector\AbstractConnector;
use Ejacobs\Phequel\Query\AbstractBaseQuery;

class Format
{

    const spacing_default = 1;
    const spacing_no_indent = 2;
    const spacing_no_space = 3;

    const type_alias = 1;
    const type_block_end = 2;
    const type_block_keyword = 3;
    const type_block_number = 4;
    const type_close_paren = 5;
    const type_column = 6;
    const type_column_json = 7;
    const type_column_unquoted = 8;
    const type_columns = 9;
    const type_comma_separated = 10;
    const type_indentation = 11;
    const type_keyword = 12;
    const type_open_paren = 13;
    const type_operator = 14;
    const type_primary_keyword = 15;
    const type_query_ending = 16;
    const type_raw = 17;
    const type_table = 18;
    const type_value = 19;
    const type_values = 20;

    public $first = true;

    private $connector;                         /* @var AbstractConnector $connector */
    private $indent = false;                    /* @var bool $indent */
    private $indentation = "\t";                /* @var bool $indentation */
    private $indentColumns = false;             /* @var bool $indentColumns */
    private $initiated = false;                 /* @var bool $initiated */
    private $interpolate = false;               /* @var bool $interpolate */
    private $level = 0;                         /* @var int $level */
    private $numericPlaceholderCounter = 1;     /* @var int $numericPlaceholderCounter */
    private $parentQuery;                       /* @var AbstractBaseQuery $parentQuery */
    private $placeholder = '?';                 /* @var string $placeholder */
    private $semicolonAtEnd = false;            /* @var bool $semicolonAtEnd */
    private $tableQuoteChar = '"';              /* @var string $tableQuoteChar */
    private $uppercase = true;                  /* @var bool $uppercase */

    /**
     * Format constructor.
     * @param AbstractExpression $parentQuery
     */
    public function __construct(AbstractExpression $parentQuery)
    {
        $this->parentQuery = $parentQuery;
    }

    /**
     * @param int $type
     * @param mixed $value
     * @param int $spacing
     * @param bool $continue
     * @return string
     */
    public function insert($type, $value = null, $spacing = self::spacing_default, $continue = true)
    {
        if (!$continue) {
            return '';
        }
        if ($this->first) {
            $spacing = self::spacing_no_space;
            $this->first = false;
        }

        switch ($type) {
            case self::type_primary_keyword:
                if (!$this->initiated) {
                    $this->initiated = true;
                    $ret = $this->keyword($value);
                } else {
                    $ret = "{$this->addIndent($spacing)}{$this->keyword($value)}";
                }
                $this->level++;
                return $ret;
            case self::type_block_keyword:
                $ret = "{$this->addIndent($spacing)}{$this->keyword($value)}";
                $ret .= $this->insert(self::type_indentation, null, self::spacing_no_space);
                return $ret;
            case self::type_keyword:
                return "{$this->addIndent($spacing)}{$this->keyword($value)}";
            case self::type_columns:
                if (!is_array($value)) {
                    $value = [$value];
                }
                $columns = [];
                foreach ($value as $column) {
                    $columns[] = $this->insert(self::type_column, $column);
                }
                return implode(',', $columns);
            case self::type_block_end:
                $ret = '';
                $this->level--;
                return $ret;
            case self::type_indentation:
                $this->level++;
                if ($value === false) {
                    return '';
                }
                return $this->addIndent($spacing);
            case self::type_table:
                if (!is_array($value)) {
                    $value = [$value];
                }
                $ret = $this->addIndent($spacing)
                    . $this->enquote($this->tableQuoteChar, $value[0]);
                if ((count($value) > 1) && is_string($value[1])) {
                    $ret .= ' ' . $this->keyword('as')
                        . ' ' . $this->enquote($this->tableQuoteChar, $value[1]);
                }
                return $ret;
            case self::type_block_number:
                return "{$this->addIndent($spacing)}{$value}";
            case self::type_value:
                $ret = $this->addIndent($spacing);
                if ($this->interpolate) {
                    return $ret . $this->connector->escape($this->parentQuery->escapeWildcards($value));
                } else {
                    return $ret. str_replace('#', $this->numericPlaceholderCounter++, $this->placeholder);
                }
            case self::type_values:
                $parts = [];
                foreach ($value as $singleValue) {
                    $parts[] = [self::type_value, $singleValue, self::spacing_no_space];
                }
                return $this->insert(self::type_comma_separated, $parts, $spacing);
            case self::type_operator:
                return "{$this->addIndent($spacing)}{$value}";
            case self::type_comma_separated:
                $strings = [];
                foreach ($value as $singleValue) {
                    if (is_array($singleValue)) {
                        $strings[] = $this->insert(
                            $singleValue[0],
                            $singleValue[1] ?? null,
                            $singleValue[2] ?? self::spacing_default
                        );
                    } else {
                        if ($singleValue instanceof AbstractExpression) {
                            $singleValue->format($this);
                        }
                        $strings[] = (string)$singleValue;
                    }
                }
                return implode(",{$this->addIndent($spacing)}", $strings);
            case self::type_open_paren:
                return "{$this->addIndent($spacing)}(";
            case self::type_close_paren:
                return "{$this->addIndent($spacing)})";
            case self::type_column:
                if (!is_array($value)) {
                    $value = [null, $value];
                }
                $ret = $this->addIndent($spacing);
                if (is_string($value[0] ?? null)) {
                    $ret .= "{$this->enquote($this->tableQuoteChar, $value[0])}.";
                }
                $ret .= $this->enquote($this->tableQuoteChar, $value[1]);
                return $ret;
            case self::type_column_unquoted:
                if (!is_array($value)) {
                    $value = [null, $value];
                }
                $ret = $this->addIndent($spacing);
                if (is_string($value[0] ?? null)) {
                    $ret .= "{$value[0]}.";
                }
                $ret .= $value[1];
                return $ret;
            case self::type_query_ending:
                if ($value === null) {
                    return ';';
                }
                return '';
            case self::type_alias:
                if ($value === null) {
                    return '';
                }
                return ' ' . $this->keyword('as') . ' ' . $this->enquote($this->tableQuoteChar, $value);
            case self::type_column_json:
                $selectors = $value[0];
                $operator = $value[1];
                $ret = '';
                if ($selectors) {
                    if (in_array($operator, ['->', '->>'])) {
                        $last = array_pop($selectors);
                        foreach ($selectors as $selector) {
                            $ret .= "->{$this->enquote("'", $selector)}";
                        }
                        $ret .= "{$operator}{$this->enquote("'", $last)}";
                    } else if (in_array($operator, ['#>', '#>>'])) {
                        $ret = "{$operator}{$this->enquote("'", '{' . implode(',', $selectors) . '}')}";
                    }
                }
                return $ret;
            case self::type_raw:
                return "{$this->addIndent($spacing)}{$value}";
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
     * @param int $spacing
     * @return string
     */
    private function addIndent($spacing = self::spacing_default)
    {
        if ($this->indent && ($spacing === self::spacing_default)) {
            return "\n" . str_repeat($this->indentation, $this->level);
        } else if (in_array($spacing, [self::spacing_default, self::spacing_no_indent])) {
            return ' ';
        } else {
            return '';
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
    public function __toString()
    {
        return (string)$this->parentQuery;
    }

}