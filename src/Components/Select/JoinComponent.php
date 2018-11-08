<?php

namespace Phion\Phequel\Components\Select;

use Phion\Phequel\AbstractExpression;
use Phion\Phequel\Format;
use Phion\Phequel\Components\ConditionsComponent;

class JoinComponent extends AbstractExpression
{

    const valid_join_types = ['left', 'right', 'inner', 'outer'];

    private $joins = [];

    /**
     * JoinComponent constructor.
     * @param string $tableName
     * @param string $tableAlias
     * @param callable $conditions
     * @param string $type
     */
    public function __construct($tableName = null, $tableAlias = null, callable $conditions = null, $type = 'left')
    {
        if ($tableName) {
            $this->addJoin($tableName, $tableAlias, $conditions, $type);
        }
    }

    /**
     * @param string $tableName
     * @param string $tableAlias
     * @param callable $nested
     * @param string $type
     * @throws \Exception
     */
    public function addJoin($tableName, $tableAlias, callable $nested, $type = 'left')
    {
        $type = strtolower($type);
        if (!in_array($type, self::valid_join_types)) {
            throw new \Exception("Invalid join type: {$type}");
        }
        $conditions = new ConditionsComponent();
        $nested($conditions);
        $this->joins[] = [
            'type'       => $type . ' join',
            'table'      => $tableName,
            'alias'      => $tableAlias,
            'conditions' => $conditions
        ];
    }

    /**
     * @return string
     */
    public function toString()
    {
        $components = [];
        foreach ($this->joins as $join) {
            $components[] = [Format::type_block_keyword, $join['type']];
            $components[] = [Format::type_table, [$join['table'], $join['alias']]];
            $components[] = [Format::type_keyword, 'on'];
            $components[] = [Format::type_open_paren, null, Format::spacing_no_indent];
            $components[] = [Format::type_indentation, false];
            $components[] = $join['conditions'];
            $components[] = [Format::type_block_end];
            $components[] = [Format::type_close_paren];
            $components[] = [Format::type_block_end];
        }
        return $this->compose(true, $components);
    }

    /**
     * @return array
     */
    public function getParams()
    {
        $conditions = [];
        foreach ($this->joins as $join) {
            $joinConditions = $join['conditions'];
            if ($joinConditions instanceof ConditionsComponent) {
                $conditions = array_merge($conditions, $joinConditions->getParams());
            }
        }
        return $conditions;
    }

}
