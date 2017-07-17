<?php

namespace Ejacobs\Phequel\Components\Select;

use Ejacobs\Phequel\AbstractExpression;

class ForComponent extends AbstractExpression
{
    private $tableNames = [];
    private $lockStrength = null;
    private $option = null;

    private $validLockStrengths = ['update', 'no key update', 'share', 'key share'];
    private $validOptions = ['nowait', 'skip locked'];

    /**
     * @param $lockStrength
     * @param array $tableNames
     * @param null $option
     * @throws \Exception
     */
    public function setFor($lockStrength, $tableNames = null, $option = null)
    {
        if (!in_array(strtolower($lockStrength), $this->validLockStrengths)) {
            throw new \Exception("lockStrength must be one of the following: " . implode(', ', $this->validLockStrengths));
        }
        if (($option !== null) && !in_array(strtolower($option), $this->validOptions)) {
            throw new \Exception("validOptions must be one of the following: " . implode(', ', $this->validOptions));
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
    public function __toString()
    {
        if ($this->lockStrength === null) {
            return '';
        }
        $formatter = $this->format();
        $ret = $formatter->insert($formatter::type_block_keyword, 'for')
            . $formatter->insert($formatter::type_keyword, $this->lockStrength);
        foreach ($this->tableNames as $table) {
            $ret .= $formatter->insert($formatter::type_table, $table);
        }
        if ($this->option !== null) {
            $ret .= $formatter->insert($formatter::type_keyword, $this->option);
        }
        $formatter->insert($formatter::type_block_end);
        return $ret;
    }

}
