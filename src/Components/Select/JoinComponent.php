<?php

namespace Ejacobs\Phequel\Components\Select;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Format;

class JoinComponent extends AbstractExpression
{
    private $joins = [];
    private $validJoinTypes = ['left', 'right', 'inner', 'outer'];

    /**
     * JoinComponent constructor.
     * @param null $tableName
     * @param null $onClause
     */
    public function __construct($tableName = null, $onClause = null)
    {
        if ($tableName) {
            $this->addJoin($tableName, $onClause);
        }
    }

    /**
     * @param $tableName
     * @param $onClause
     * @param string $type
     * @throws \Exception
     */
    public function addJoin($tableName, $onClause, $type = 'left')
    {
        $type = strtolower($type);
        if (in_array($type, $this->validJoinTypes)) {
            $this->joins[] = [
                'type'  => $type . ' join',
                'table' => $tableName,
                'on'    => $onClause
            ];
        } else {
            throw new \Exception("Invalid join type: {$type}");
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $components = [];
        foreach ($this->joins as $join) {
            $components[] = [Format::type_block_keyword, $join['type']];
            $components[] = [Format::type_table, $join['table']];
            $components[] = [Format::type_keyword, 'on'];
            $components[] = [Format::type_on_clause, $join['on']];
            $components[] = [Format::type_block_end];
        }
        return $this->compose(true, $components);
    }

}
