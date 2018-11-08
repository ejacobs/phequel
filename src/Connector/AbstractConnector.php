<?php

namespace Phion\Phequel\Connector;

use Phion\Phequel\Factories\QueryFactoryInterface;

abstract class AbstractConnector implements QueryFactoryInterface
{

    abstract public function connect(array $credentials, bool $persistent = true);

    abstract public function execute($query, $params = []);

    abstract public function fetchAll($query, $params = []);

    abstract public function firstRow($query, $params = []);

    abstract public function lastInsertId($name = null);

    abstract public function disconnect();

    abstract public function errorInfo();

    abstract public function escape($value);

}