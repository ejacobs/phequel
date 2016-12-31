<?php

namespace Ejacobs\QueryBuilder\Query;

use Ejacobs\QueryBuilder\Component\Insert\InsertComponent;
use Ejacobs\QueryBuilder\Component\Insert\RowComponent;
use Ejacobs\QueryBuilder\Component\TableComponent;

abstract class AbstractInsertQuery extends AbstractBaseQuery
{

    /* @var RowComponent $rowComponent */
    protected $rowComponent;

    /* @var InsertComponent $insertComponent */
    protected $insertComponent = null;

    /**
     * AbstractInsertQuery constructor.
     * @param $tableName
     */
    public function __construct($tableName = null)
    {
        $this->insertComponent = new InsertComponent();
        $this->rowComponent = new RowComponent();
        parent::__construct($tableName);
    }

    /**
     * @param $tableName
     * @return $this
     */
    public function into($tableName)
    {
        $this->tableComponent = new TableComponent($tableName);
        return $this;
    }

    /**
     * @param array $columns
     * @return $this
     */
    public function columns(array $columns)
    {
        $this->rowComponent->columns($columns);
        return $this;
    }

    /**
     * @param array $row
     * @return $this
     */
    public function addRow(array $row)
    {
        $this->rowComponent->addRow($row);
        return $this;
    }

    /**
     * @param array $rows
     * @return $this
     */
    public function addRows(array $rows)
    {
        foreach ($rows as $row) {
            $this->rowComponent->addRow($row);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->rowComponent->getParams();
    }


}