<?php

namespace Ejacobs\QueryBuilder\Component\Select;

use Ejacobs\QueryBuilder\Component\AbstractComponent;

class FetchComponent extends AbstractComponent
{
    private $count = null;
    private $type = null;
    private $rowType = null;

    private $validTypes = ['first', 'next'];
    private $validRowTypes = ['row', 'rows'];

    /**
     * @param int $count
     * @param string $type
     * @param string $rowType
     * @throws \Exception
     */
    public function setFetch($count = 1, $type = 'first', $rowType = 'row')
    {
        if (($type !== null) && !in_array(strtolower($type), $this->validTypes)) {
            throw new \Exception("type must be one of the following: " . implode(', ', $this->validTypes));
        }
        if (($rowType !== null) && !in_array(strtolower($rowType), $this->validRowTypes)) {
            throw new \Exception("rowType must be one of the following: " . implode(', ', $this->validRowTypes));
        }
        $this->count = $count;
        $this->type = $type;
        $this->rowType = $rowType;
    }

    public function __toString()
    {
        $ret = '';
        if ($this->count) {
            $ret .= " FETCH {$this->type}";
            if ($this->count) {
                $ret .= " {$this->count}";
            }
            $ret .= " {$this->rowType} ONLY";
        }
        return $ret;
    }

}
