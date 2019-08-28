<?php

namespace App\Tests;

use App\Foo;
use PHPUnit\Framework\TestCase;

/**
 * Class BarTest
 */
class FooTest extends TestCase
{
    /**
     * @test
     */
    public function testFoo()
    {
        $this->assertEquals('foo', (new Foo())->foo());
    }
}
