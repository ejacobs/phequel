<?php

namespace Phion\Phequel\Query;

use Phion\Phequel\Components\Update\SetComponent;
use Phion\Phequel\Components\Update\UpdateComponent;
use Phion\Phequel\Components\WhereComponent;
use Phion\Phequel\Query\Traits\WhereTrait;

abstract class AbstractUpdateQuery extends AbstractBaseQuery
{

    use WhereTrait;

    /* @var UpdateComponent $updateComponent */
    protected $updateComponent;

    /* @var SetComponent $setComponent */
    protected $setComponent;

    /* @var WhereComponent $whereComponent */
    protected $whereComponent;

    /**
     * AbstractUpdateQuery constructor.
     * @param null $tableName
     * @param null $alias
     */
    public function __construct($tableName = null, $alias = null)
    {
        $this->updateComponent = new UpdateComponent($tableName, $alias);
        $this->setComponent = new SetComponent();
        $this->whereComponent = new WhereComponent();
        parent::__construct();
    }

    /**
     * @param $tableName
     * @param null $alias
     * @return $this
     */
    public function update($tableName, $alias = null)
    {
        $this->updateComponent = new UpdateComponent($tableName, $alias);
        return $this;
    }

    /**
     * @param string $column
     * @param string $value
     * @return $this
     */
    public function set(string $column, $value)
    {
        $this->setComponent->setValue($column, $value);
        return $this;
    }

    /**
     * @param array $values
     * @return $this
     */
    public function setMultiple($values)
    {
        foreach ($values as $column => $value) {
            $this->setComponent->setValue($column, $value);
        }
        return $this;
    }

    public function getParams(): array
    {
        return array_merge(
            $this->setComponent->getParams(),
            $this->whereComponent->getParams()
        );
    }

}