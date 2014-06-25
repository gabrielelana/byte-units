<?php

namespace ByteUnits;

class CompareTest extends \PHPUnit_Framework_TestCase
{
    public function testCompareWithSameUnitSystem()
    {
        $this->assertTrue(Metric::bytes(1)->isEqualTo(Metric::bytes(1)));
        $this->assertTrue(Metric::bytes(1)->isGreaterThanOrEqualTo(Metric::bytes(1)));
        $this->assertTrue(Metric::bytes(5)->isGreaterThan(Metric::bytes(1)));
        $this->assertTrue(Metric::bytes(1)->isLessThanOrEqualTo(Metric::bytes(1)));
        $this->assertTrue(Metric::bytes(1)->isLessThan(Metric::bytes(5)));

        $this->assertTrue(Binary::bytes(1)->isEqualTo(Binary::bytes(1)));
        $this->assertTrue(Binary::bytes(1)->isGreaterThanOrEqualTo(Binary::bytes(1)));
        $this->assertTrue(Binary::bytes(5)->isGreaterThan(Binary::bytes(1)));
        $this->assertTrue(Binary::bytes(1)->isLessThanOrEqualTo(Binary::bytes(1)));
        $this->assertTrue(Binary::bytes(1)->isLessThan(Binary::bytes(5)));
    }

    public function testCompareWithOtherUnitSystem()
    {
        $this->assertTrue(Metric::bytes(1)->isEqualTo(Binary::bytes(1)));
        $this->assertTrue(Metric::bytes(1)->isGreaterThanOrEqualTo(Binary::bytes(1)));
        $this->assertTrue(Metric::bytes(5)->isGreaterThan(Binary::bytes(1)));
        $this->assertTrue(Metric::bytes(1)->isLessThanOrEqualTo(Binary::bytes(1)));
        $this->assertTrue(Metric::bytes(1)->isLessThan(Binary::bytes(5)));

        $this->assertTrue(Binary::bytes(1)->isEqualTo(Metric::bytes(1)));
        $this->assertTrue(Binary::bytes(1)->isGreaterThanOrEqualTo(Metric::bytes(1)));
        $this->assertTrue(Binary::bytes(5)->isGreaterThan(Metric::bytes(1)));
        $this->assertTrue(Binary::bytes(1)->isLessThanOrEqualTo(Metric::bytes(1)));
        $this->assertTrue(Binary::bytes(1)->isLessThan(Metric::bytes(5)));
    }

    public function testAutoboxing()
    {
        $this->assertTrue(Metric::bytes(1)->isEqualTo(1));
        $this->assertTrue(Metric::bytes(1)->isEqualTo('1B'));
        $this->assertTrue(Metric::bytes(1)->isGreaterThanOrEqualTo(1));
        $this->assertTrue(Metric::bytes(1)->isGreaterThanOrEqualTo('1B'));
        $this->assertTrue(Metric::bytes(5)->isGreaterThan(1));
        $this->assertTrue(Metric::bytes(5)->isGreaterThan('1B'));
        $this->assertTrue(Metric::bytes(1)->isLessThanOrEqualTo(1));
        $this->assertTrue(Metric::bytes(1)->isLessThanOrEqualTo('1B'));
        $this->assertTrue(Metric::bytes(1)->isLessThan(5));
        $this->assertTrue(Metric::bytes(1)->isLessThan('5B'));
    }
}
