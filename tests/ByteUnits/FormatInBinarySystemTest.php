<?php

namespace ByteUnits;

class FormatInBinarySystemTest extends \PHPUnit_Framework_TestCase
{
    public function testBytesNamedConstructor()
    {
        $this->assertEquals(new Binary(1), Binary::bytes(1));
    }

}
