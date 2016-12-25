<?php

namespace Ejacobs\QueryBuilder\Query;

use Ejacobs\QueryBuilder\Component\InsertRowComponent;
use Ejacobs\QueryBuilder\FluentConnection;

abstract class AbstractInsertQuery extends AbstractBaseQuery
{

    protected $columns;
    /* @var InsertRowComponent[] $insertRowComponents */
    protected $insertRowComponents = [];

    /**
     * InsertQuery constructor.
     * @param $tableName
     * @param $columns
     */
    public function __construct($tableName, $columns)
    {
        $this->columns = $columns;
        parent::__construct( $tableName);
    }

    /**
     * @param array $data
     * @return $this
     */
    public function addRow(array $data)
    {
        $this->insertRowComponents[] = new InsertRowComponent($this->columns, $data);
        return $this;
    }

    /**
     * @param array $rows
     * @return $this
     */
    public function addRows(array $rows)
    {
        foreach ($rows as $data) {
            $this->insertRowComponents[] = new InsertRowComponent($this->columns, $data);
        }
        return $this;
    }

    public function getParams()
    {
        $ret = [];
        foreach ($this->insertRowComponents as $insertRowComponent) {
            $ret = array_merge($ret, $insertRowComponent->getData());
        }
        return $ret;
    }



    public function debug()
    {
        $params = end($this->insertRowComponents)->getData();
        $query = (string)$this;

        foreach ($this->columns as $column) {
            $nextParam = array_shift($params);
            if ($nextParam === null) {
                $nextParam = 'null';
            }
            else {
                $nextParam = "'" . $nextParam . "'";
            }
            $query = $this->strReplaceFirst('?', $nextParam, $query);
        }
        return $query . ";";
    }

    protected function strReplaceFirst($from, $to, $subject)
    {
        $from = '/'.preg_quote($from, '/').'/';

        return preg_replace($from, $to, $subject, 1);
    }


}