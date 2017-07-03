<?php

namespace Ejacobs\Phequel\Components\Select;

use Ejacobs\Phequel\Components\AbstractComponent;

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
        $type = strtolower($type);
        if (in_array($type, $this->validJoinTypes)) {
            $this->joins[] = [
                'type'  => $type,
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
            // TODO: Validate $onClause
            $onClause = implode(' ', $join['on']);
            $ret .= $formatter->insertKeyword(" {$join['type']} join ")
                . $join['table']
                . $formatter->insertKeyword(" on ")
                . '(' . $onClause . ')';
        }
        return $ret;
    }

}
