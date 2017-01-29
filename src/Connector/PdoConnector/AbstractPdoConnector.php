<?php

namespace Ejacobs\Phequel\Connector;

use Ejacobs\Phequel\Query\AbstractBaseQuery;

/**
 * Class PdoConnector
 * @package Ejacobs\Phequel\Connector\
 * @method \PDO getNextConnection()
 * @method \PDO[] pool()
 */
abstract class PdoConnector extends AbstractConnector
{

    protected $driver;
    protected $params;

    const driver = null;

    /**
     * AbstractConnector constructor.
     * @param array|null $params
     * @param bool $connect
     * @param bool $usePooling
     * @param int $poolSize
     */
    public function __construct(array $params, $connect = true, $usePooling = false, $poolSize = 10)
    {
        $this->params = $params;
        $this->usePooling = $usePooling;
        $this->poolSize = $poolSize;
        if ($connect) {
            if ($usePooling) {
                for ($i=0; $i<$poolSize; $i++) {
                    $this->pool[] = $this->connect();
                }
            }
            else {
                $this->pool[] = $this->connect();
            }
        }
    }


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
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
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
        return $statement->fetch(\PDO::FETCH_ASSOC);
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
        return static::driver . ':' . implode(';', $parts);
    }

    public function lastInsertId($name = null)
    {
        return $this->getNextConnection()->lastInsertId($name);
    }


}