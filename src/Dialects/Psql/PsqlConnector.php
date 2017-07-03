<?php

namespace Ejacobs\Phequel\Dialects\Psql;

use Ejacobs\Phequel\Connector\AbstractPdoConnector;

/**
 * Class PsqlConnector
 * @package Ejacobs\Phequel\Dialects\Psql
 */
class PsqlConnector extends AbstractPdoConnector
{
    const driver = 'pgsql';

    /**
     * @return PsqlQueryFactory
     */
    public function create()
    {
        return new PsqlQueryFactory();
    }

}