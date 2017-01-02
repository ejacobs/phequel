<?php

namespace Ejacobs\Phequel\Query;

use Ejacobs\Phequel\Component\Delete\DeleteComponent;
use Ejacobs\Phequel\Component\TableComponent;
use Ejacobs\Phequel\Component\WhereComponent;

abstract class AbstractDeleteQuery extends AbstractBaseQuery
{
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
        $this->deleteComponent = new DeleteComponent();
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
     * @param array|string $expressions
     * @param array|string|int $params
     * @return $this
     */
    public function where($expressions, $params = [])
    {
        if (!($expressions instanceof WhereComponent)) {
            $expressions = new WhereComponent($expressions, $params, 'and');
        }
        $this->whereComponent->addConditions($expressions);
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