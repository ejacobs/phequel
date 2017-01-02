<?php

namespace Ejacobs\QueryBuilder\Component\Update;

use Ejacobs\QueryBuilder\Component\AbstractComponent;

class UpdateComponent extends AbstractComponent
{

    /**
     * @return string
     */
    public function __toString()
    {
        return 'UPDATE';
    }

}
