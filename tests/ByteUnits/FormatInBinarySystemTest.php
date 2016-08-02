<?php

namespace ByteUnits;

class FormatInBinarySystemTest extends \PHPUnit_Framework_TestCase
{
    public function testBytesNamedConstructor()
    {
        $this->assertEquals(new Binary(1), Binary::bytes(1));
    }

    public function testFormatInMostReadableByteUnit()
    {
        $this->assertEquals('0B', Binary::bytes(0)->format());
        $this->assertEquals('1B', Binary::bytes(1)->format());
        $this->assertEquals('1.00KiB', Binary::bytes(1024)->format());
        $this->assertEquals('1.25KiB', Binary::bytes(1280)->format());
        $this->assertEquals('1.50MiB', Binary::bytes(1572864)->format());
        $this->assertEquals('1.75GiB', Binary::bytes(1879048192)->format());
        $this->assertEquals('2.00TiB', Binary::bytes(2199023255552)->format());
    }

    public function testFormatInMostReadableByteUnitWithPrecision()
    {
        $this->assertEquals('1.201216MiB', Binary::bytes(1259566)->format(6));
        $this->assertEquals('1.201216MiB', Binary::bytes(1259566)->format('/000000'));
        $this->assertEquals('1.201216MiB', Binary::bytes(1259566)->format('/6'));
    }

    public function testFormatInMostReadableByteUnitWithSepartor()
    {
        $this->assertEquals('1.20 MiB', Binary::bytes(1259566)->format(2, ' '));
        $this->assertEquals('1.20/MiB', Binary::bytes(1259566)->format(2, '/'));
    }

    public function testFormatInByteUnit()
    {
        $bytes = Binary::bytes(1250000000);
        $this->assertEquals('1250000000B', $bytes->format('B'));
        $this->assertEquals('1220703.12KiB', $bytes->format('KiB'));
        $this->assertEquals('1192.09MiB', $bytes->format('MiB'));
        $this->assertEquals('1.16GiB', $bytes->format('GiB'));
    }

    public function testFormatInByteUnitIsCaseInsensitive()
    {
        $bytes = Binary::bytes(1250000000);
        $this->assertEquals('1250000000B', $bytes->format('B'));
        $this->assertEquals('1250000000B', $bytes->format('b'));
        $this->assertEquals('1220703.12KiB', $bytes->format('KiB'));
        $this->assertEquals('1220703.12KiB', $bytes->format('Kib'));
        $this->assertEquals('1220703.12KiB', $bytes->format('KIB'));
        $this->assertEquals('1220703.12KiB', $bytes->format('kiB'));
        $this->assertEquals('1220703.12KiB', $bytes->format('kib'));
    }

    public function testFormatInByteUnitWithPrecision()
    {
        $bytes = Binary::bytes(1250000000);
        $this->assertEquals('1.164153GiB', $bytes->format('GiB/000000'));
        $this->assertEquals('1.164GiB', $bytes->format('GiB/000'));
        $this->assertEquals('0.001TiB', $bytes->format('TiB/000'));
        $this->assertEquals('0.001137TiB', $bytes->format('TiB/6'));
    }

    public function testNumberOfBytes()
    {
        $this->assertEquals('0', Binary::bytes(0)->numberOfBytes());
        $this->assertEquals('1', Binary::bytes(1)->numberOfBytes());
        $this->assertEquals('1024', Binary::bytes(1024)->numberOfBytes());
        $this->assertEquals('1280', Binary::bytes(1280)->numberOfBytes());
        $this->assertEquals('1572864', Binary::bytes(1572864)->numberOfBytes());
        $this->assertEquals('1879048192', Binary::bytes(1879048192)->numberOfBytes());
        $this->assertEquals('2199023255552', Binary::bytes(2199023255552)->numberOfBytes());
    }
}
