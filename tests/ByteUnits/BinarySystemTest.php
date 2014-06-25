<?php

namespace ByteUnits;

class BinarySystemTest extends \PHPUnit_Framework_TestCase
{
    public function testKilobytesConstructor()
    {
        $this->assertEquals(Binary::bytes(1024), Binary::kilobytes(1));
    }

    public function testMegabytesConstructor()
    {
        $this->assertEquals(Binary::bytes(1048576), Binary::megabytes(1));
    }

    public function testGigabytesConstructor()
    {
        $this->assertEquals(Binary::bytes(1073741824), Binary::gigabytes(1));
    }

    public function testTerabytesConstructor()
    {
        $this->assertEquals(Binary::bytes(1099511627776), Binary::terabytes(1));
    }

    public function testPetabytesConstructor()
    {
        $this->assertEquals(Binary::bytes(1125899906842624), Binary::petabytes(1));
    }

    public function testExabytesConstructor()
    {
        $this->assertEquals(Binary::bytes(1152921504606846976), Binary::exabytes(1));
    }

    /**
     * @expectedException ByteUnits\NegativeBytesException
     */
    public function testCannotBeNegative()
    {
        Binary::bytes(-1);
    }
}
