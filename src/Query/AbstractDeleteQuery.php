<?php

namespace Ejacobs\Phequel\Query;

use Ejacobs\Phequel\Components\Delete\DeleteComponent;
use Ejacobs\Phequel\Components\TableComponent;
use Ejacobs\Phequel\Components\WhereComponent;
use Ejacobs\Phequel\Query\Traits\WhereTrait;

abstract class AbstractDeleteQuery extends AbstractBaseQuery
{
    use WhereTrait;

    /* @var DeleteComponent $whereComponent */
    protected $deleteComponent;

    /* @var WhereComponent $whereComponent */
    protected $whereComponent;

    /**
     * AbstractSelectQuery constructor.
     * @param $tableName
     */
    public function __construct($tableName = null)
    {
        $this->deleteComponent = new DeleteComponent($tableName);
        $this->whereComponent = new WhereComponent();
        parent::__construct($tableName);
    }

    /**
     * @param $tableName
     * @return $this
     */
    public function from($tableName)
    {
        $this->tableComponent = new TableComponent($tableName);
        return $this;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->whereComponent->getParams();
    }

}