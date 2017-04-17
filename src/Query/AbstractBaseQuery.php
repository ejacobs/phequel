<?php

namespace Ejacobs\Phequel\Query;

use Ejacobs\Phequel\Component\TableComponent;

abstract class AbstractBaseQuery
{
    protected $tableComponent = null;

    public $allowedWildcards = null;

    const valid_wildcards = ['%', '_'];
    const valid_operators = ['=', '!=', '>', '>=', '<', '<=', 'like', 'in', 'is', 'between', 'not like', 'similar to',
        'not similar to'];

    /**
     * AbstractBaseQuery constructor.
     * @param $tableName
     * @param array $allowedWildcards
     */
    public function __construct($tableName, array $allowedWildcards = ['%' => '%', '_' => '_'])
    {
        $this->tableComponent = new TableComponent($tableName);
        $this->setWildcardCharacters($allowedWildcards);
    }

    /**
     * @return string
     */
    abstract public function __toString();

    /**
     * @return array
     */
    abstract public function getParams();

    /**
     * Set the allowed wildcard characters. Wildcard characters not included in this list will be escaped when they
     * are passed as parameters. You can map various character to SQL wildcard characters, for example ['*' => '%']
     * will cause asterisks to be converted to SQL "percent" wildcards.
     *
     * @param array $wildcards
     * @return $this
     */
    public function setWildcardCharacters(array $wildcards)
    {
        $this->allowedWildcards = $wildcards;
        return $this;
    }

    /**
     * @param $string
     * @throws \Exception
     * @return string
     */
    public function escapeWildcards($string)
    {
        if (!isset($this->allowedWildcards['%'])) {
            $string = str_replace('%', '\\%', $string);
        }

        if (!isset($this->allowedWildcards['_'])) {
            $string = str_replace('_', '\\_', $string);
        }

        foreach ($this->allowedWildcards as $replace => $with) {
            if (!in_array($with, self::valid_wildcards)) {
                throw new \Exception($replace . ' is not a valid SQL wildcard');
            }
            $string = str_replace($replace, $with, $string);
        }

        return $string;
    }


}