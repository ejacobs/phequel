<?php

namespace Ejacobs\Phequel\Components\Update;

use Ejacobs\Phequel\AbstractExpression;

class UpdateComponent extends AbstractExpression
{

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->format()->insertKeyword('update');
    }

}
