<?php

namespace Ejacobs\Phequel\Query;

use Ejacobs\Phequel\Components\TableComponent;
use Ejacobs\Phequel\Components\Update\SetComponent;
use Ejacobs\Phequel\Components\Update\UpdateComponent;
use Ejacobs\Phequel\Components\WhereComponent;
use Ejacobs\Phequel\Query\Traits\WhereTrait;

abstract class AbstractUpdateQuery extends AbstractBaseQuery
{
    use WhereTrait;

    /* @var UpdateComponent $updateComponent */
    protected $updateComponent;

    /* @var SetComponent $setComponent */
    protected $setComponent;

    /**
     * AbstractUpdateQuery constructor.
     * @param null|string $tableName
     * @throws \Exception
     */
    public function __construct(string $tableName = null)
    {
        $this->updateComponent = new UpdateComponent($tableName);
        $this->setComponent = new SetComponent();
        $this->whereComponent = new WhereComponent();
        parent::__construct($tableName);
    }

    /**
     * @param null|string $tableName
     * @return $this
     */
    public function update($tableName)
    {
        $this->tableComponent = new TableComponent($tableName);
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