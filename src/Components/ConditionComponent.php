<?php

namespace Ejacobs\Phequel\Components;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Format;

class ConditionComponent extends AbstractExpression
{
    const valid_operators = ['=', '!=', '>', '>=', '<', '<=', 'like', 'ilike', 'in', 'is', 'between', 'not like',
        'similar to', 'not similar to'];
    const subquery_operators = ['in', 'not in', 'any', 'some', 'all'];

    private $left;
    private $operator;
    private $right;

    /**
     * ConditionComponent constructor.
     * @param $left
     * @param $operator
     * @param $right
     */
    public function __construct($left, $operator, $right)
    {
        $this->left = $left;
        $this->operator = $operator;
        $this->right = $right;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $components = [];
        if ($this->left instanceof AbstractExpression) {
            $components[] = $this->left;
        } else if (is_bool($this->left)) {
            $components[] = [Format::type_raw, ($this->left) ? 'true' : 'false'];
        } else if (is_int($this->left)) {
            $components[] = [Format::type_raw, $this->left];
        } else {
            $components[] = [Format::type_column, $this->left];
        }

        if ($this->operator !== null) {
            if (in_array($this->operator, self::valid_operators)) {
                $components[] = [Format::type_operator, $this->operator];
            }
            if ($this->right instanceof AbstractExpression) {
                $components[] = [Format::type_indentation, null, true];
                $components[] = $this->right;
                $components[] = [Format::type_block_end, null, true];
            }
            else if (is_array($this->right)) {
                if (in_array($this->operator, self::subquery_operators)) {
                    $components[] = [Format::type_indentation, null];
                    $components[] = [Format::type_values, $this->right, Format::spacing_no_indent];
                    $components[] = [Format::type_block_end, null];
                }
                else {
                    $components[] = [Format::type_column, $this->right, Format::spacing_no_indent];
                }
            }
            else {
                $components[] = [Format::type_value, $this->right, Format::spacing_no_indent];
            }
        }
        return $this->compose(true, $components);
    }

    /**
     * @return array
     */
    public function getParams()
    {
        // If there there is a valid operator then the right side is a value
        if ($this->operator) {
            if ($this->right instanceof AbstractExpression) {
                return $this->right->getParams();
            }
            else if (is_array($this->right)) {
                if (in_array($this->operator, self::subquery_operators)) {
                    return $this->right;
                }
            }
            else {
                return [$this->right];
            }
        }
        return [];
    }

}
