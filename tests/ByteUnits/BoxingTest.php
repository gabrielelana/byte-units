<?php

namespace ByteUnits;

class BoxingTest extends \PHPUnit_Framework_TestCase
{
    public function testBoxAnInteger()
    {
        $this->assertEquals(bytes(42), box(42));
    }

    public function testBoxAString()
    {
        $this->assertEquals(parse('1.256MB'), box('1.256MB'));
    }

    public function testBoxAByteUnit()
    {
        $byteUnitInMetricSystem = Metric::bytes(42);
        $byteUnitInBinarySystem = Binary::bytes(42);
        $this->assertEquals($byteUnitInMetricSystem, box($byteUnitInMetricSystem));
        $this->assertEquals($byteUnitInBinarySystem, box($byteUnitInBinarySystem));
    }

    /**
     * @expectedException ByteUnits\ConversionException
     */
    public function testBoxAnObjectThatIsNotAByteUnit()
    {
        box(new \StdClass());
    }
}
