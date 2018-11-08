<?php

namespace Phion\Phequel\Components\Select;

use Phion\Phequel\AbstractExpression;
use Phion\Phequel\Format;

class ForComponent extends AbstractExpression
{

    const valid_lock_strengths = ['update', 'no key update', 'share', 'key share'];
    const valid_options = ['nowait', 'skip locked'];

    private $tableNames = [];
    private $lockStrength = null;
    private $option = null;

    /**
     * @param $lockStrength
     * @param array $tableNames
     * @param null $option
     * @throws \Exception
     */
    public function setFor($lockStrength, $tableNames = null, $option = null)
    {
        if (!in_array(strtolower($lockStrength), self::valid_lock_strengths)) {
            throw new \Exception("lockStrength must be one of the following: " . implode(', ', self::valid_lock_strengths));
        }
        if (($option !== null) && !in_array(strtolower($option), self::valid_options)) {
            throw new \Exception("validOptions must be one of the following: " . implode(', ', self::valid_options));
        }
        if (($tableNames !== null) && !is_array($tableNames)) {
            $tableNames = [$tableNames];
        }
        $this->tableNames = $tableNames;
        $this->lockStrength = $lockStrength;
        $this->option = $option;
    }

    /**
     * @return string
     */
    public function toString()
    {
        $components = [];
        $components[] = [Format::type_block_keyword, 'for'];
        $components[] = [Format::type_keyword, $this->lockStrength];
        foreach ($this->tableNames as $table) {
            $components[] = [Format::type_table, $table];
        }
        if ($this->option !== null) {
            $components[] = [Format::type_keyword, $this->option];
        }
        $components[] = [Format::type_block_end];
        return $this->compose(!!$this->lockStrength, $components);
    }

}
