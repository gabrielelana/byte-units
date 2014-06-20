<?php

namespace ByteUnits;

class ConversionBetweenSystemsTest extends \PHPUnit_Framework_TestCase
{
    public function testBytesAreInMetricStystem()
    {
        $this->assertInstanceOf('ByteUnits\Metric', bytes(1));
    }

    public function testConvertFromMetricToBinarySystem()
    {
        $this->assertInstanceOf('ByteUnits\Binary', Metric::bytes(1)->asBinary());
    }

    public function testConvertFromBinaryToMetricSystem()
    {
        $this->assertInstanceOf('ByteUnits\Metric', Binary::bytes(1)->asMetric());
    }
}
