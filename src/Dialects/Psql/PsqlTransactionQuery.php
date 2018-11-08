<?php

namespace Phion\Phequel\Dialects\Psql;

use Phion\Phequel\Query\AbstractTransactionQuery;

class PsqlTransactionQuery extends AbstractTransactionQuery
{

    /* @var PsqlAbstractTransactionComponent $subQueries */
    protected $subQueries;

    /**
     * PsqlTransactionQuery constructor.
     * @param callable $nested
     */
    public function __construct(callable $nested)
    {
        parent::__construct($nested);
        $this->subQueries = new PsqlAbstractTransactionComponent();
        $nested($this->subQueries);
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->compose(true, [
            $this->beginComponent,
            $this->subQueries,
            $this->commitComponent,
        ]);
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->subQueries->getParams();
    }

}
