<?php

use PHPUnit\Framework\TestCase;

/**
 * @covers Email
 */
final class EmailTest extends TestCase
{
    public function testTrivial()
    {
        $this->assertEquals('foo', 'foo');
    }

}
