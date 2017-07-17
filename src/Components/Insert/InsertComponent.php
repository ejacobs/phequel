<?php

namespace Ejacobs\Phequel\Components\Insert;

use Ejacobs\Phequel\AbstractExpression;

class InsertComponent extends AbstractExpression
{

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->format()->insertKeyword('insert into');
    }

}
