<?php

namespace Ejacobs\Phequel\Connector;

use Ejacobs\Phequel\Query\AbstractBaseQuery;

/**
 * Class PdoConnector
 * @package Ejacobs\Phequel\Connector\
 * @method \PDO[] pool()
 */
abstract class AbstractPdoConnector extends AbstractConnector
{

    const driver = null;

    /* @var \PDO $pdo */
    protected $pdo;
    protected $params = [];

    private $errorInfo = null;

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
        if ($connect) {
            $this->pdo = $this->connect();
        }
    }

    /**
     * @return \PDO
     */
    public function connect()
    {
        return new \PDO($this->getConnectionString(), null, null);
    }

    /**
     * @param AbstractBaseQuery|string $query
     * @param array $params
     * @return bool
     */
    public function execute($query, $params = [])
    {
        if ($query instanceof AbstractBaseQuery) {
            $params = $query->getParams();
            $query = $query->toString();
        }
        $statement = $this->pdo->prepare($query);
        $ret = $statement->execute($params);
        $this->errorInfo = $statement->errorInfo();
        return $ret;
    }

    /**
     * @param AbstractBaseQuery|string $query
     * @param array $params
     * @return array
     */
    public function fetchAll($query, $params = [])
    {
        if ($query instanceof AbstractBaseQuery) {
            $params = $query->getParams();
            $query = $query->toString();
        }
        $statement = $this->pdo->prepare($query);
        $statement->execute($params);
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param AbstractBaseQuery|string $query
     * @param array $params
     * @return array
     */
    public function firstRow($query, $params = [])
    {
        if ($query instanceof AbstractBaseQuery) {
            $params = $query->getParams();
        }
        $statement = $this->pdo->prepare($query);
        $statement->execute($params);
        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @return bool
     */
    public function disconnect()
    {
        $this->pdo = null;
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

    /**
     * @param null $name
     * @return string
     */
    public function lastInsertId($name = null)
    {
        return $this->pdo->lastInsertId($name);
    }

    /**
     * @return array
     */
    public function errorInfo()
    {
        return $this->errorInfo;
    }

    /**
     * @param $value
     * @return string
     */
    public function escape($value)
    {
        return  $this->pdo->quote($value);
    }

}