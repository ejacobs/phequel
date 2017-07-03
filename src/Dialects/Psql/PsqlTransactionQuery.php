<?php

namespace Ejacobs\Phequel\Dialects\Psql;

use Ejacobs\Phequel\Query\AbstractTransactionQuery;

class PsqlTransactionQuery extends AbstractTransactionQuery
{

    /**
     * PsqlTransactionQuery constructor.
     * @param callable $nested
     */
    public function __construct(callable $nested)
    {
        parent::__construct($nested);
        $this->subQueries = new PsqlNestedQueryFactory();
        $nested($this->subQueries);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $formatter = $this->formatter();
        return (string)$this->beginComponent->injectFormatter($formatter)
        . (string)$this->subQueries->injectFormatter($formatter)
        . (string)$this->commitComponent->injectFormatter($formatter);
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->subQueries->getParams();
    }

}
