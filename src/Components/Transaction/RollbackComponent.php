<?php

namespace Ejacobs\Phequel\Components\Transaction;

use Ejacobs\Phequel\AbstractExpression;

class RollbackComponent extends AbstractExpression
{
    private $rollbackTo;

    /**
     * RollbackComponent constructor.
     * @param null|string $rollbackTo
     */
    public function __construct($rollbackTo = null)
    {
        $this->rollbackTo = $rollbackTo;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $formatter = $this->formatter();
        $ret = $formatter->insertKeyword('rollback');
        if (is_String($this->rollbackTo)) {
            $ret .= $formatter->insertKeyword(' to ') . $this->rollbackTo;
        }
        return "{$ret};\n";
    }

}
