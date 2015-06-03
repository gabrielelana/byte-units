<?php

namespace ByteUnits;

class ParseTest extends \PHPUnit_Framework_TestCase
{
    public function testParseInMetricSystem()
    {
        $this->assertEquals(Metric::bytes(1000), parse('1.00kB'));
        $this->assertEquals(Metric::bytes(1250000), parse('1.25MB'));
    }

    public function testParseInBinarySystem()
    {
        $this->assertEquals(Binary::bytes(1024), parse('1.00KiB'));
        $this->assertEquals(Binary::bytes(1310720), parse('1.25MiB'));
    }

    public function testParseWithoutUnit()
    {
        $this->assertEquals(Metric::bytes(1000), parse('1000'));
    }

    public function testParseWithSeparator()
    {
        $this->assertEquals(Metric::bytes(1000), parse('1.00 kB'));
        $this->assertEquals(Metric::bytes(1000), parse('1.00/kB'));
        $this->assertEquals(Metric::bytes(1000), parse('1.00~~~kB'));
    }

    /**
     * @expectedException ByteUnits\ParseException
     */
    public function testInvalidByteFormat()
    {
        parse('Not a valid byte format');
    }

    /**
     * @expectedException ByteUnits\ParseException
     */
    public function testInvalidByteFormatForBinarySystem()
    {
        Binary::parse('1.00kB');
    }

    /**
     * @expectedException ByteUnits\ParseException
     */
    public function testInvalidByteFormatForMetricSystem()
    {
        Metric::parse('1.00KiB');
    }
}
