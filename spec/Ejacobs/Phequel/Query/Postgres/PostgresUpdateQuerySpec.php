<?php

namespace spec\Ejacobs\Phequel\Query\Postgres;

use Ejacobs\Phequel\Query\Postgres\PostgresUpdateQuery;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PostgresUpdateQuerySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('table_name');
        $this->shouldHaveType(PostgresUpdateQuery::class);
    }
}
