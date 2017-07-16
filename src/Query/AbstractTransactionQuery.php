<?php

namespace Ejacobs\Phequel\Query;

use Ejacobs\Phequel\AbstractExpression;
use Ejacobs\Phequel\Components\Transaction\BeginComponent;
use Ejacobs\Phequel\Components\Transaction\CommitComponent;
use Ejacobs\Phequel\Factories\QueryFactoryInterface;

abstract class AbstractTransactionQuery extends AbstractExpression
{

    /* @var BeginComponent $beginComponent */
    protected $beginComponent;

    /* @var CommitComponent $beginComponent */
    protected $commitComponent;

    /* @var QueryFactoryInterface $subQueries */
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

}