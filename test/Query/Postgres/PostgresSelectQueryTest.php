<?php

use PHPUnit\Framework\TestCase;

/**
 * @covers Email
 */
final class PostgresSelectQueryTest extends TestCase
{
    public function testTableNameConstructor()
    {
        $query1 = new \Ejacobs\Phequel\Query\Postgres\PostgresSelectQuery();
        $query1->select('*')->from('mytable');
        $query2 = new \Ejacobs\Phequel\Query\Postgres\PostgresSelectQuery('mytable');
        $this->assertEquals((string)$query1, (string)$query2);
        $this->assertEquals((string)$query1, 'SELECT * FROM mytable');
    }

    public function testWhereCondition()
    {
        $query1 = new \Ejacobs\Phequel\Query\Postgres\PostgresSelectQuery('mytable');
        $query1->where('mycolumn', 'LIKE', 'foo');
        $this->assertEquals((string)$query1, 'SELECT * FROM mytable WHERE mycolumn LIKE ?');
        $this->assertEquals($query1->getParams(), ['foo']);
    }

    public function testEscapeWildcards()
    {
        $query1 = new \Ejacobs\Phequel\Query\Postgres\PostgresSelectQuery('mytable', ['*' => '%']);
        $query1->where('mycolumn', 'LIKE', 'foo*');
        $this->assertEquals($query1->getParams(), ['foo%']);

        $query2 = new \Ejacobs\Phequel\Query\Postgres\PostgresSelectQuery('mytable', ['*' => '%']);
        $query2->where('mycolumn', 'LIKE', 'foo%');
        $this->assertEquals($query2->getParams(), ['foo\\%']);
    }


    // TODO: test where any
    // TODO: test where all
    // TODO: test order by
    // TODO: test limit

}
