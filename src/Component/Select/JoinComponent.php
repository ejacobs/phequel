<?php

namespace Ejacobs\QueryBuilder\Component\Select;

use Ejacobs\QueryBuilder\Component\AbstractComponent;

class JoinComponent extends AbstractComponent
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
        if (in_array(strtolower($type), $this->validJoinTypes)) {
            $type = strtoupper($type);
        }
        else {
            throw new \Exception("Invalid join type: {$type}");
        }

        $this->joins[] = [
            'type' => $type,
            'table' => $tableName,
            'on' => $onClause
        ];
    }

    public function __toString()
    {
        $ret = '';
        foreach ($this->joins as $join) {
            $ret .= " {$join['type']} JOIN {$join['table']} ON ({$join['on']})";
        }
        return $ret;
    }

}
