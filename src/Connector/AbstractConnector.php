<?php

namespace Ejacobs\Phequel\Connector;

use Ejacobs\Phequel\Factories\QueryFactoryInterface;
use Ejacobs\Phequel\Formatter;

abstract class AbstractConnector
{

    /**
     * @return QueryFactoryInterface
     */
    abstract public function create();

    abstract public function connect();

    abstract public function execute($query, $params = []);

    abstract public function fetchAll($query, $params = []);

    abstract public function firstRow($query, $params = []);

    abstract public function lastInsertId($name = null);

    abstract public function disconnect();

    abstract public function errorInfo();

    /**
     * @return Formatter
     */
    public function formatter()
    {
        return new Formatter();
    }

}