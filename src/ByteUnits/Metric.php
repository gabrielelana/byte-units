<?php

namespace ByteUnits;

class Metric extends System
{
    private static $base = 1000;
    private static $suffixes = ['YB'=>8, 'ZB'=>7, 'EB'=>6, 'PB'=>5, 'TB'=>4, 'GB'=>3, 'MB'=>2, 'kB'=>1, 'B'=>0];

    public function __construct($numberOfBytes, $precision = self::NORMAL_PRECISION)
    {
        $scale = new PowerScale(self::$base, self::$suffixes, self::MAXIMUM_PRECISION);
        $formatter = new Formatter($scale, $precision);
        parent::__construct($numberOfBytes, $formatter);
    }
}
