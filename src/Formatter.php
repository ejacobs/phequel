<?php

namespace Ejacobs\Phequel;

class Formatter
{

    private $indent = true;
    private $indentWhereClauses = true;
    private $numberOfSpaces = 4;
    private $tabsOrSpaces = 'spaces';
    private $uppercaseKeywords = true;
    private $placeholderType = '?';
    private $numericPlaceholderCounter = 0;
    private $interpolate = false;

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
     * @return $this
     */
    public function interpolate()
    {
        $this->interpolate = true;
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
     * @return string
     */
    public function insertPlaceholder()
    {
        if ($this->placeholderType === '#') {
            $this->numericPlaceholderCounter++;
            return (string)$this->numericPlaceholderCounter;
        } else {
            return '?';
        }
    }

}