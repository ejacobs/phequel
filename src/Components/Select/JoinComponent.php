<?php

namespace Ejacobs\Phequel\Components\Select;

use Ejacobs\Phequel\AbstractExpression;

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

    public function __toString()
    {
        $ret = '';
        $formatter = $this->formatter();
        foreach ($this->joins as $join) {
            $ret .= $formatter->insert($formatter::type_block_keyword, $join['type']);
            $ret .= $formatter->insert($formatter::type_table, $join['table']);
            $ret .= $formatter->insert($formatter::type_keyword, 'on');
            $ret .= $formatter->insert($formatter::type_on_clause, $join['on']);
            $ret .= $formatter->insert($formatter::type_end);
        }
        return $ret;
    }

}
