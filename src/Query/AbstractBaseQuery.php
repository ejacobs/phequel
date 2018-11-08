<?php

namespace Phion\Phequel\Query;

use Phion\Phequel\AbstractExpression;
use Phion\Phequel\Components\EndingComponent;

abstract class AbstractBaseQuery extends AbstractExpression
{

    const valid_wildcards = ['%', '_'];

    public $allowedWildcards = [];

    protected $endingComponent = null;

    /**
     * AbstractBaseQuery constructor.
     */
    public function __construct()
    {
        $this->endingComponent = new EndingComponent();
    }

    /**
     * Set the allowed wildcard characters. Wildcard characters not included in this list will be escaped when they
     * are passed as parameters. You can map various character to SQL wildcard characters, for example ['*' => '%']
     * will cause asterisks to be converted to SQL "percent" wildcards.
     *
     * @param array $wildcards
     * @return $this
     * @throws \Exception
     */
    public function setWildcardCharacters(array $wildcards)
    {
        if ($wildcards !== null) {
            foreach ($wildcards as $replace => $with) {
                if (!in_array($with, self::valid_wildcards)) {
                    throw new \Exception($with . ' is not a valid SQL wildcard');
                }
            }
            $this->allowedWildcards = $wildcards;
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getWildcardCharacters()
    {
        return $this->allowedWildcards;
    }

    /**
     * Converts wildcards specified in the constructor into valid SQL wildcards. In some instances asterisks (*) may be
     * preferred to percent signs (%) when writing wildcard queries. This method will make those conversions as well as
     * escape any wildcard characters not explicitly defined in the constructor for the query object.
     *
     * @param string $string
     * @throws \Exception
     * @return string
     */
    public function escapeWildcards($string)
    {
        $allowed = $this->getWildcardCharacters();
        if (!isset($allowed['%'])) {
            $string = str_replace('%', '\\%', $string);
        }
        if (!isset($allowed['_'])) {
            $string = str_replace('_', '\\_', $string);
        }
        foreach ($allowed as $replace => $with) {
            $string = str_replace($replace, $with, $string);
        }
        return $string;
    }

    /**
     * @param bool $semicolon
     * @return $this
     */
    public function semicolon($semicolon = true)
    {
        $this->endingComponent->semicolon($semicolon);
        return $this;
    }

    /**
     * @param array $paramArrays
     * @return array
     */
    protected function replaceWildcardsParams(array $paramArrays)
    {
        $ret = [];
        foreach ($paramArrays as $paramArray) {
            foreach ($paramArray as $param) {
                $ret[] = $this->escapeWildcards($param);
            }
        }
        return $ret;
    }

}