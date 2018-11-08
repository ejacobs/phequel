<?php

namespace Phion\Phequel\Query;

use Phion\Phequel\Components\Delete\DeleteComponent;
use Phion\Phequel\Components\WhereComponent;
use Phion\Phequel\Query\Traits\WhereTrait;

abstract class AbstractDeleteQuery extends AbstractBaseQuery
{

    use WhereTrait;

    /* @var DeleteComponent $whereComponent */
    protected $deleteComponent;

    /* @var WhereComponent $whereComponent */
    protected $whereComponent;

    /**
     * AbstractSelectQuery constructor.
     */
    public function __construct()
    {
        $this->deleteComponent = new DeleteComponent();
        $this->whereComponent = new WhereComponent();
        parent::__construct();
    }

    /**
     * @param string $tableName
     * @param null|string $alias
     * @return $this
     */
    public function from($tableName, $alias = null)
    {
        $this->deleteComponent = new DeleteComponent($tableName, $alias);
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