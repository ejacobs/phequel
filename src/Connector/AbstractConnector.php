<?php

namespace Ejacobs\Phequel\Connector;

abstract class AbstractConnector
{
    protected $driver;
    protected $params;
    protected $usePooling;
    protected $poolSize;
    protected $pool = [];

    /**
     * AbstractConnector constructor.
     * @param $driver
     * @param array|null $params
     * @param bool $connect
     * @param bool $usePooling
     * @param int $poolSize
     */
    public function __construct($driver, array $params = null, $connect = true, $usePooling = false, $poolSize = 10)
    {
        $this->driver = $driver;
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

    /**
     * @return mixed
     * @throws \Exception
     */
    protected function getNextConnection()
    {
        if ($this->pool === []) {
            throw new \Exception('Tried to execute query before connections has been established');
        }
        $connection = next($this->pool);
        if ($connection === false) {
            $connection = reset($this->pool);
        }
        return $connection;
    }

    /**
     * @return array
     */
    protected function pool()
    {
        return $this->pool;
    }

    abstract public function connect();

    abstract public function execute($query, $params = []);

    abstract public function fetchAll($query, $params = []);

    abstract public function firstRow($query, $params = []);

    abstract public function lastInsertId($name = null);

    abstract public function disconnect();


}