<?php

namespace Ejacobs\Phequel\Components\Delete;

use Ejacobs\Phequel\AbstractExpression;

class DeleteComponent extends AbstractExpression
{

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->formatter()->insertKeyword('delete from');
    }

}
