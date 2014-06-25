<?php

namespace ByteUnits;

class CompareTest extends \PHPUnit_Framework_TestCase
{
    public function testCompareWithSameUnitSystem()
    {
        $this->assertTrue(Metric::bytes(1)->equalTo(Metric::bytes(1)));
        $this->assertTrue(Metric::bytes(1)->greaterThanOrEqualTo(Metric::bytes(1)));
        $this->assertTrue(Metric::bytes(5)->greaterThan(Metric::bytes(1)));
        $this->assertTrue(Metric::bytes(1)->lessThanOrEqualTo(Metric::bytes(1)));
        $this->assertTrue(Metric::bytes(1)->lessThan(Metric::bytes(5)));

        $this->assertTrue(Binary::bytes(1)->equalTo(Binary::bytes(1)));
        $this->assertTrue(Binary::bytes(1)->greaterThanOrEqualTo(Binary::bytes(1)));
        $this->assertTrue(Binary::bytes(5)->greaterThan(Binary::bytes(1)));
        $this->assertTrue(Binary::bytes(1)->lessThanOrEqualTo(Binary::bytes(1)));
        $this->assertTrue(Binary::bytes(1)->lessThan(Binary::bytes(5)));
    }

    public function testCompareWithOtherUnitSystem()
    {
        $this->assertTrue(Metric::bytes(1)->equalTo(Binary::bytes(1)));
        $this->assertTrue(Metric::bytes(1)->greaterThanOrEqualTo(Binary::bytes(1)));
        $this->assertTrue(Metric::bytes(5)->greaterThan(Binary::bytes(1)));
        $this->assertTrue(Metric::bytes(1)->lessThanOrEqualTo(Binary::bytes(1)));
        $this->assertTrue(Metric::bytes(1)->lessThan(Binary::bytes(5)));

        $this->assertTrue(Binary::bytes(1)->equalTo(Metric::bytes(1)));
        $this->assertTrue(Binary::bytes(1)->greaterThanOrEqualTo(Metric::bytes(1)));
        $this->assertTrue(Binary::bytes(5)->greaterThan(Metric::bytes(1)));
        $this->assertTrue(Binary::bytes(1)->lessThanOrEqualTo(Metric::bytes(1)));
        $this->assertTrue(Binary::bytes(1)->lessThan(Metric::bytes(5)));
    }

    public function testAutoboxing()
    {
        $this->assertTrue(Metric::bytes(1)->equalTo(1));
        $this->assertTrue(Metric::bytes(1)->equalTo('1B'));
        $this->assertTrue(Metric::bytes(1)->greaterThanOrEqualTo(1));
        $this->assertTrue(Metric::bytes(1)->greaterThanOrEqualTo('1B'));
        $this->assertTrue(Metric::bytes(5)->greaterThan(1));
        $this->assertTrue(Metric::bytes(5)->greaterThan('1B'));
        $this->assertTrue(Metric::bytes(1)->lessThanOrEqualTo(1));
        $this->assertTrue(Metric::bytes(1)->lessThanOrEqualTo('1B'));
        $this->assertTrue(Metric::bytes(1)->lessThan(5));
        $this->assertTrue(Metric::bytes(1)->lessThan('5B'));
    }
}
