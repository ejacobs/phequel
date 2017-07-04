<?php

namespace Ejacobs\Phequel;

use Ejacobs\Phequel\Components\AbstractComponent;
use Ejacobs\Phequel\Connector\AbstractConnector;
use Ejacobs\Phequel\Factories\EscaperInterface;
use Ejacobs\Phequel\Query\AbstractQuery;

class Formatter
{
    private $indent = true;
    private $indentWhereClauses = true;
    private $interpolate = false;
    private $newlineAtEnd = false;
    private $numberOfSpaces = 4;
    private $numericPlaceholderCounter = 0;
    private $parentQuery;
    private $placeholderType = '?';
    private $semicolonAtEnd = false;
    private $tabsOrSpaces = 'spaces';
    private $uppercaseKeywords = true;

    /* @var AbstractConnector $connector */
    private $connector;

    /**
     * Formatter constructor.
     * @param AbstractQuery $parentQuery
     */
    public function __construct(AbstractQuery $parentQuery)
    {
        $this->parentQuery = $parentQuery;
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
        $ret .= $this->insertEnding();
        return $ret;
    }

    /**
     * @return $this
     */
    public function indent()
    {
        $this->indent = true;
        return $this;
    }

    /**
     * @return $this
     */
    public function flatten()
    {
        $this->indent = false;
        return $this;
    }

    /**
     * @return $this
     */
    public function useTabs()
    {
        $this->tabsOrSpaces = 'tabs';
        return $this;
    }

    /**
     * @return $this
     */
    public function useSpaces()
    {
        $this->tabsOrSpaces = 'spaces';
        return $this;
    }

    /**
     * @param int $numberOfSpaces
     * @return $this
     */
    public function indentationSpaces($numberOfSpaces)
    {
        $this->numberOfSpaces = $numberOfSpaces;
        return $this;
    }

    /**
     * @return $this
     */
    public function uppercaseKeywords()
    {
        $this->uppercaseKeywords = true;
        return $this;
    }

    /**
     * @return $this
     */
    public function lowercaseKeywords()
    {
        $this->uppercaseKeywords = false;
        return $this;
    }

    /**
     * @return $this
     */
    public function indentWhereClauses()
    {
        $this->indentWhereClauses = true;
        return $this;
    }

    /**
     * @return $this
     */
    public function placeholderQuestionMarks()
    {
        $this->placeholderType = '?';
        return $this;
    }

    /**
     * @return $this
     */
    public function placeholderNumbered()
    {
        $this->placeholderType = '#';
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
     * @param bool $newlineAtEnd
     * @return $this
     */
    public function newlineAfterEnd($newlineAtEnd = true)
    {
        $this->newlineAtEnd = $newlineAtEnd;
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
     * @param string $keyword
     * @return string
     */
    public function insertKeyword($keyword)
    {
        if ($this->uppercaseKeywords) {
            return strtoupper($keyword);
        } else {
            return strtolower($keyword);
        }
    }

    /**
     * @param $value
     * @return string
     */
    public function insertPlaceholder($value)
    {
        if ($this->interpolate) {
            return $this->connector->escape($value);
        } else if ($this->placeholderType === '#') {
            $this->numericPlaceholderCounter++;
            return (string)$this->numericPlaceholderCounter;
        } else {
            return '?';
        }
    }

    /**
     * @return string
     */
    public function insertEnding()
    {
        $ret = '';
        if ($this->semicolonAtEnd) {
            $ret .= ';';
        }
        if ($this->newlineAtEnd) {
            $ret .= "\n";
        }
        return $ret;
    }

    /**
     * @return string
     */
    function __toString()
    {
        return (string)$this->parentQuery;
    }

}