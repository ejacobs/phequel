<?php

namespace Phion\Phequel\Query;

use Phion\Phequel\AbstractExpression;
use Phion\Phequel\Components\Transaction\BeginComponent;
use Phion\Phequel\Components\Transaction\CommitComponent;
use Phion\Phequel\Factories\QueryFactoryInterface;

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