<?php

namespace Ejacobs\Phequel\Component\Select;

use Ejacobs\Phequel\Component\AbstractComponent;

class HavingComponent extends AbstractComponent
{
    private $conditions = [];

    /**
     * HavingComponent constructor.
     * @param null $sql
     * @param array $params
     */
    public function __construct($sql = null, $params = [])
    {
        if ($sql) {
            $this->addCondition($sql, $params);
        }
    }

    public function addCondition($sql, $params = [])
    {
        if (!is_array($params)) {
            $params = [$params];
        }
        $this->conditions[] = [
            'sql'    => $sql,
            'params' => $params
        ];
    }

    /**
     * @return array|mixed
     */
    public function getParams()
    {
        $params = [];
        foreach ($this->conditions as $condition) {
            $params = array_merge($params, $condition['params']);
        }
        return $params;
    }

    public function __toString()
    {
        if ($this->conditions) {
            return " HAVING " . implode(', ', array_column($this->conditions, 'sql'));
        } else {
            return '';
        }
    }

}
