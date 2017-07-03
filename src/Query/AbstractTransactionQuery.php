<?php

namespace Ejacobs\Phequel\Query;

use Ejacobs\Phequel\Components\Transaction\BeginComponent;
use Ejacobs\Phequel\Components\Transaction\CommitComponent;
use Ejacobs\Phequel\Factories\NestedQueryFactoryInterface;
use Ejacobs\Phequel\Query\Traits\FormatterTrait;

abstract class AbstractTransactionQuery
{
    use FormatterTrait;

    /* @var BeginComponent $beginComponent */
    protected $beginComponent;

    /* @var CommitComponent $beginComponent */
    protected $commitComponent;

    /* @var NestedQueryFactoryInterface $subQueries */
    protected $subQueries;

    /**
     * AbstractTransactionQuery constructor.
     * @param callable $nested
     */
    public function __construct(callable $nested)
    {
        $this->beginComponent = new BeginComponent();
        $this->commitComponent = new CommitComponent();
    }

    /**
     * @return array
     */
    abstract public function getParams();

    /**
     * @return string
     */
    abstract public function __toString();

}