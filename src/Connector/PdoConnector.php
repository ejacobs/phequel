<?php

namespace Ejacobs\Phequel\Connector;

use Ejacobs\Phequel\Query\AbstractBaseQuery;

/**
 * Class PdoConnector
 * @package Ejacobs\Phequel\Connector\
 * @method \PDO getNextConnection()
 * @method \PDO[] pool()
 */
class PdoConnector extends AbstractConnector
{

    public function connect()
    {
        return new \PDO($this->getConnectionString());
    }

    /**
     * @param $query
     * @param array $params
     * @return bool
     */
    public function execute($query, $params = [])
    {
        if ($query instanceof AbstractBaseQuery) {
            $params = $query->getParams();
        }
        $connection = $this->getNextConnection();
        $statement = $connection->prepare($query);
        return $statement->execute($params);
    }

    /**
     * @param $query
     * @param array $params
     * @return array
     */
    public function fetchAll($query, $params = [])
    {
        if ($query instanceof AbstractBaseQuery) {
            $params = $query->getParams();
        }
        $connection = $this->getNextConnection();
        $statement = $connection->prepare($query);
        $statement->execute($params);
        return $statement->fetchAll();
    }

    /**
     * @param $query
     * @param array $params
     * @return array
     */
    public function firstRow($query, $params = [])
    {
        if ($query instanceof AbstractBaseQuery) {
            $params = $query->getParams();
        }
        $connection = $this->getNextConnection();
        $statement = $connection->prepare($query);
        $statement->execute($params);
        return $statement->fetch();
    }

    /**
     * @return bool
     */
    public function disconnect()
    {
        $this->pool = [];
        return true;
    }

    /**
     * @return string
     */
    protected function getConnectionString()
    {
        $parts = [];
        foreach ($this->params as $key => $value) {
            $parts[] = "{$key}={$value}";
        }
        return $this->driver . ':' . implode(';', $parts);
    }

}