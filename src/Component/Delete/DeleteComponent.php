<?php

namespace Ejacobs\QueryBuilder\Component\Delete;

use Ejacobs\QueryBuilder\Component\AbstractComponent;

class DeleteComponent extends AbstractComponent
{

    /**
     * @return string
     */
    public function __toString()
    {
        return 'DELETE';
    }

}
