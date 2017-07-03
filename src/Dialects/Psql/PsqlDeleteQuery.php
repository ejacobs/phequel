<?php

namespace Ejacobs\Phequel\Dialects\Psql;

use Ejacobs\Phequel\Query\AbstractDeleteQuery;

class PsqlDeleteQuery extends AbstractDeleteQuery
{

    /**
     * @return string
     * @throws \Exception
     */
    public function __toString()
    {
        $formatter = $this->formatter();
        return (string)$this->deleteComponent->injectFormatter($formatter)
            . (string)$this->tableComponent->injectFormatter($formatter)
            . (string)$this->whereComponent->injectFormatter($formatter);
    }

}