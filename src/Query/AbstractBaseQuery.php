<?php

namespace Ejacobs\Phequel\Query;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Components\EndingComponent;

abstract class AbstractBaseQuery extends AbstractExpression
{

    public $allowedWildcards = null;
    protected $tableComponent = null;
    protected $endingComponent = null;

    const valid_wildcards = ['%', '_'];
    const valid_operators = ['=', '!=', '>', '>=', '<', '<=', 'like', 'ilike', 'in', 'is', 'between', 'not like',
        'similar to', 'not similar to'];

    /**
     * AbstractBaseQuery constructor.
     * @param null|string $tableName
     * @param null|string $alias
     */
    public function __construct($tableName, $alias = null)
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
     */
    public function setWildcardCharacters(array $wildcards)
    {
        $this->allowedWildcards = $wildcards;
        return $this;
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