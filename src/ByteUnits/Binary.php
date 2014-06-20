<?php

namespace ByteUnits;

class Binary extends System
{
    public function __construct($numberOfBytes, $precision = self::NORMAL_PRECISION)
    {
        $base = 1024;
        $suffixes = ['YiB'=>8, 'ZiB'=>7, 'EiB'=>6, 'PiB'=>5, 'TiB'=>4, 'GiB'=>3, 'MiB'=>2, 'KiB'=>1, 'B'=>0];
        $scale = new PowerScale($base, $suffixes, self::MAXIMUM_PRECISION);
        $formatter = new Formatter($scale, $precision);
        parent::__construct($numberOfBytes, $formatter);
    }
}
