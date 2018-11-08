<?php

use PHPUnit\Framework\TestCase;
use Phion\Phequel\Dialects\Psql\PsqlSelectQuery;

/**
 * @covers Email
 */
final class PsqlSelectQueryTest extends TestCase
{

    public function testWhereCondition()
    {
        $query1 = new PsqlSelectQuery();
        $query1->from('mytable')->where('mycolumn', 'like', 'foo');
        $this->assertEquals((string)$query1, 'SELECT * FROM "mytable" WHERE "mycolumn" like ?');
        $this->assertEquals($query1->getParams(), ['foo']);
    }

    public function testEscapeWildcards()
    {
        $query1 = new PsqlSelectQuery();
        $query1->setWildcardCharacters(['*' => '%']);
        $query1->where('mycolumn', 'LIKE', 'foo*')->from('mytable');
        $this->assertEquals($query1->getParams(), ['foo%']);
        $query2 = new PsqlSelectQuery();
        $query2->from('mytable')
            ->setWildcardCharacters(['*' => '%'])
            ->where('mycolumn', 'LIKE', 'foo%');
        $this->assertEquals($query2->getParams(), ['foo\%']);
    }

    public function testOrderBy()
    {
        $query1 = new PsqlSelectQuery();
        $query1->selectRaw('*')->from('mytable')->orderBy('age', 'asc');
        $this->assertEquals((string)$query1, 'SELECT * FROM "mytable" ORDER BY "age" ASC');
    }

    public function testLimit()
    {
        $query1 = new PsqlSelectQuery();
        $query1->selectRaw('*')->from('mytable')->limit(100);
        $this->assertEquals((string)$query1, 'SELECT * FROM "mytable" LIMIT 100');
    }

    // TODO: test where any
    // TODO: test where all

}
