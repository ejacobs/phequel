<?php

namespace Ejacobs\Phequel\Components\Select;

use Ejacobs\Phequel\Components\AbstractComponent;

class ForComponent extends AbstractComponent
{
    private $tableNames = null;
    private $lockStrength = null;
    private $option = null;

    private $validLockStrengths = ['update', 'no key update', 'share', 'key share'];
    private $validOptions = ['nowait', 'skip locked'];

    /**
     * @param $lockStrength
     * @param null $tableNames
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

    public function __toString()
    {
        $ret = '';
        if ($this->lockStrength) {
            $ret .= $this->formatter()->insertKeyword(' for ' . $this->lockStrength);
            if ($this->tableNames) {
                $ret .= ' ' . implode($this->tableNames, ', ');
            }
            if ($this->option) {
                $ret .= $this->formatter()->insertKeyword(' ' . $this->option);
            }
        }
        return $ret;
    }

}
