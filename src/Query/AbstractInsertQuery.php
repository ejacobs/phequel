<?php

namespace Ejacobs\Phequel\Query;

use Ejacobs\Phequel\Components\Insert\InsertComponent;
use Ejacobs\Phequel\Components\Insert\RowComponent;
use Ejacobs\Phequel\Components\Insert\RowsComponent;
use Ejacobs\Phequel\Components\TableComponent;

abstract class AbstractInsertQuery extends AbstractBaseQuery
{

    /* @var RowsComponent $rowsComponent */
    protected $rowsComponent;

    /* @var InsertComponent $insertComponent */
    protected $insertComponent = null;

    /**
     * AbstractInsertQuery constructor.
     * @param $tableName
     */
    public function __construct($tableName = null)
    {
        $this->insertComponent = new InsertComponent($tableName);
        $this->rowsComponent = new RowsComponent();
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
        $this->rowsComponent->columns($columns);
        return $this;
    }

    /**
     * @param array $row
     * @return $this
     */
    public function addRow(array $row)
    {
        $this->rowsComponent->addRow($row);
        return $this;
    }

    /**
     * @param array $rows
     * @return $this
     */
    public function addRows(array $rows)
    {
        foreach ($rows as $row) {
            $this->rowsComponent->addRow($row);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->rowsComponent->getParams();
    }

}