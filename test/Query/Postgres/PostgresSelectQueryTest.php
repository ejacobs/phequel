<?php

use PHPUnit\Framework\TestCase;

/**
 * @covers Email
 */
final class PsqlSelectQueryTest extends TestCase
{
    public function testTableNameConstructor()
    {
        $query1 = new \Ejacobs\Phequel\Query\Psql\PsqlSelectQuery();
        $query1->select('*')->from('mytable');
        $query2 = new \Ejacobs\Phequel\Query\Psql\PsqlSelectQuery('mytable');
        $this->assertEquals((string)$query1, (string)$query2);
        $this->assertEquals((string)$query1, 'SELECT * FROM mytable');
    }

    public function testWhereCondition()
    {
        $query1 = new \Ejacobs\Phequel\Query\Psql\PsqlSelectQuery('mytable');
        $query1->where('mycolumn', 'LIKE', 'foo');
        $this->assertEquals((string)$query1, 'SELECT * FROM mytable WHERE mycolumn LIKE ?');
        $this->assertEquals($query1->getParams(), ['foo']);
    }

    public function testEscapeWildcards()
    {
        $query1 = new \Ejacobs\Phequel\Query\Psql\PsqlSelectQuery('mytable', ['*' => '%']);
        $query1->where('mycolumn', 'LIKE', 'foo*');
        $this->assertEquals($query1->getParams(), ['foo%']);

        $query2 = new \Ejacobs\Phequel\Query\Psql\PsqlSelectQuery('mytable', ['*' => '%']);
        $query2->where('mycolumn', 'LIKE', 'foo%');
        $this->assertEquals($query2->getParams(), ['foo\%']);
    }

    public function testOrderBy()
    {
        $query1 = new \Ejacobs\Phequel\Query\Psql\PsqlSelectQuery();
        $query1->select('*')->from('mytable')->orderBy('age', 'asc');
        $this->assertEquals((string)$query1, 'SELECT * FROM mytable ORDER BY age ASC');
    }

    public function testLimit()
    {
        $query1 = new \Ejacobs\Phequel\Query\Psql\PsqlSelectQuery();
        $query1->select('*')->from('mytable')->limit(100);
        $this->assertEquals((string)$query1, 'SELECT * FROM mytable LIMIT 100');
    }


    // TODO: test where any
    // TODO: test where all

}
