<?php

namespace Ejacobs\Phequel\Query;

use Ejacobs\Phequel\Component\TableComponent;
use Ejacobs\Phequel\FluentConnection;

abstract class AbstractBaseQuery
{
    protected $tableComponent = null;

    protected $allowedWildcards = null;

    const valid_wildcards = ['%', '_'];
    const valid_operators = ['=', '!=', '>', '>=', '<', '<=', 'like', 'in', 'is', 'between', 'not like', 'similar to',
        'not similar to'];

    /**
     * AbstractBaseQuery constructor.
     * @param string|null $tableName
     * @param array $allowedWildcards
     */
    public function __construct($tableName, $allowedWildcards = ['%' => '%', '_' => '_'])
    {
        $this->tableComponent = new TableComponent($tableName);
        $this->allowedWildcards = $allowedWildcards;
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