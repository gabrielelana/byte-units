<?php

namespace ByteUnits;

class Metric extends System
{
    public function __construct($numberOfBytes, $precision = self::NORMAL_PRECISION)
    {
        $base = 1000;
        $suffixes = ['YB'=>8, 'ZB'=>7, 'EB'=>6, 'PB'=>5, 'TB'=>4, 'GB'=>3, 'MB'=>2, 'kB'=>1, 'B'=>0];
        $scale = new PowerScale($base, $suffixes, self::MAXIMUM_PRECISION);
        $formatter = new Formatter($scale, $precision);
        parent::__construct($numberOfBytes, $formatter);
    }
}
