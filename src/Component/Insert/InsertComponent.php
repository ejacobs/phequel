<?php

namespace Ejacobs\QueryBuilder\Component\Insert;

use Ejacobs\QueryBuilder\Component\AbstractComponent;

class InsertComponent extends AbstractComponent
{

    /**
     * @return string
     */
    public function __toString()
    {
        return 'INSERT INTO';
    }

}
