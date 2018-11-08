<?php

namespace Phion\Phequel\Dialects\Mysql;

use Phion\Phequel\Query\AbstractTransactionQuery;

class MysqlTransactionQuery extends AbstractTransactionQuery
{

    /* @var MysqlAbstractTransactionComponent $subQueries */
    protected $subQueries;

    /**
     * MysqlTransactionQuery constructor.
     * @param callable $nested
     */
    public function __construct(callable $nested)
    {
        parent::__construct($nested);
        $this->subQueries = new MysqlAbstractTransactionComponent();
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
