<?php

namespace spec\Ejacobs\Phequel\Query\Postgres;

use Ejacobs\Phequel\Query\Postgres\PostgresInsertQuery;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PostgresInsertQuerySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('table_name', ['column1']);
        $this->shouldHaveType(PostgresInsertQuery::class);
    }
}
