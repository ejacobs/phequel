<?php

namespace spec\Ejacobs\Phequel\Query\Postgres;

use Ejacobs\Phequel\Query\Postgres\PostgresDeleteQuery;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PostgresDeleteQuerySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('table_name');
        $this->shouldHaveType(PostgresDeleteQuery::class);
    }
}
