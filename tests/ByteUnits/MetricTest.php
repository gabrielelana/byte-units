<?php

namespace ByteUnits;

class MetricTest extends \PHPUnit_Framework_TestCase
{
    public function testBytesAreInMetricStystem()
    {
        $this->assertInstanceOf('ByteUnits\Metric', bytes(1));
    }

    public function testBytesNamedConstructor()
    {
        $this->assertEquals(new Metric(1), Metric::bytes(1));
    }

    public function testFormatInMostReadableByteUnit()
    {
        $this->assertEquals('1B', Metric::bytes(1)->format());
        $this->assertEquals('1.00kB', Metric::bytes(1000)->format());
        $this->assertEquals('1.25kB', Metric::bytes(1250)->format());
        $this->assertEquals('1.50MB', Metric::bytes(1500000)->format());
        $this->assertEquals('1.75GB', Metric::bytes(1750000000)->format());
        $this->assertEquals('2.00TB', Metric::bytes(2000000000000)->format());
        $this->assertEquals('2.25PB', Metric::bytes(2250000000000000)->format());
        $this->assertEquals('2.50EB', Metric::bytes(2500000000000000000)->format());
        $this->assertEquals('2.75ZB', Metric::bytes(2750000000000000000000)->format());
        $this->assertEquals('3.00YB', Metric::bytes(3000000000000000000000000)->format());
    }

    public function testFormatInMostReadableByteUnitWithPrecision()
    {
        $this->assertEquals('1.259566MB', Metric::bytes(1259566)->format(6));
        $this->assertEquals('1.259566MB', Metric::bytes(1259566)->format('/000000'));
        $this->assertEquals('1.259566MB', Metric::bytes(1259566)->format('/6'));
    }

    public function testFormatInByteUnit()
    {
        $bytes = Metric::bytes(1250000000);
        $this->assertEquals('1250000000B', $bytes->format('B'));
        $this->assertEquals('1250000.00kB', $bytes->format('kB'));
        $this->assertEquals('1250.00MB', $bytes->format('MB'));
        $this->assertEquals('1.25GB', $bytes->format('GB'));
    }
}
