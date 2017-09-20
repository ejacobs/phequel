<?php

namespace Ejacobs\Phequel\Query;

use Ejacobs\Phequel\Components\Insert\InsertComponent;
use Ejacobs\Phequel\Components\Insert\RowsComponent;

abstract class AbstractInsertQuery extends AbstractBaseQuery
{

    /* @var RowsComponent $rowsComponent */
    protected $rowsComponent;

    /* @var InsertComponent $insertComponent */
    protected $insertComponent = null;

    /**
     * AbstractInsertQuery constructor.
     * @param array|null $rows
     */
    public function __construct(array $rows = null)
    {
        $this->rowsComponent = new RowsComponent($rows);
        parent::__construct();
    }

    /**
     * @param string $tableName
     * @param null|string $alias
     * @return $this
     */
    public function into($tableName, $alias = null)
    {
        $this->insertComponent = new InsertComponent($tableName, $alias);
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
    public function row(array $row)
    {
        $this->rowsComponent->addRow($row);
        return $this;
    }

    /**
     * @param array $rows
     * @return $this
     */
    public function rows(array $rows)
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