<?php

namespace ByteUnits;

class ArithmeticTest extends \PHPUnit_Framework_TestCase
{
    public function testAddInSameUnitSystem()
    {
        $this->assertEquals(Metric::bytes(10), Metric::bytes(5)->add(Metric::bytes(5)));
        $this->assertEquals(Binary::bytes(10), Binary::bytes(5)->add(Binary::bytes(5)));
    }

    public function testRemoveInSameUnitSystem()
    {
        $this->assertEquals(Metric::bytes(3), Metric::bytes(5)->remove(Metric::bytes(2)));
        $this->assertEquals(Binary::bytes(3), Binary::bytes(5)->remove(Binary::bytes(2)));
    }

    public function testAutoboxing()
    {
        $this->assertEquals(Metric::bytes(10), Metric::bytes(5)->add(5));
        $this->assertEquals(Metric::bytes(10), Metric::bytes(5)->add('5B'));
        $this->assertEquals(Metric::bytes(3), Metric::bytes(5)->remove(2));
        $this->assertEquals(Metric::bytes(3), Metric::bytes(5)->remove('2B'));
    }

    /**
     * @expectedException ByteUnits\NegativeBytesException
     */
    public function testCannotRemoveMoreBytesThanYouHave()
    {
        Metric::bytes(5)->remove(Metric::bytes(10));
    }

    public function testPreserveSystemUnitOfReceiver()
    {
        $this->assertEquals(Metric::bytes(3), Metric::bytes(5)->remove(Binary::bytes(2)));
        $this->assertNotEquals(Binary::bytes(3), Metric::bytes(5)->remove(Binary::bytes(2)));
    }

    public function testPreserveFormatPrecisionOfReceiver()
    {
        $result = Metric::bytes(3000, 6)->add(Binary::bytes(256, 2));
        $this->assertEquals(Metric::bytes(3256, 6)->format(), $result->format());
    }
}
