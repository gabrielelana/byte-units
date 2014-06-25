<?php

namespace ByteUnits;

class MetricSystemTest extends \PHPUnit_Framework_TestCase
{
    public function testKilobytesConstructor()
    {
        $this->assertEquals(Metric::bytes(1000), Metric::kilobytes(1));
    }

    public function testMegabytesConstructor()
    {
        $this->assertEquals(Metric::bytes(1000000), Metric::megabytes(1));
    }

    public function testGigabytesConstructor()
    {
        $this->assertEquals(Metric::bytes(1000000000), Metric::gigabytes(1));
    }

    public function testTerabytesConstructor()
    {
        $this->assertEquals(Metric::bytes(1000000000000), Metric::terabytes(1));
    }

    public function testPetabytesConstructor()
    {
        $this->assertEquals(Metric::bytes(1000000000000000), Metric::petabytes(1));
    }

    public function testExabytesConstructor()
    {
        $this->assertEquals(Metric::bytes(1000000000000000000), Metric::exabytes(1));
    }

    /**
     * @expectedException ByteUnits\NegativeBytesException
     */
    public function testCannotBeNegative()
    {
        Metric::bytes(-1);
    }
}
