<?php

namespace ByteUnits;

class Binary extends System
{
    private static $base = 1024;
    private static $suffixes = ['YiB'=>8, 'ZiB'=>7, 'EiB'=>6, 'PiB'=>5, 'TiB'=>4, 'GiB'=>3, 'MiB'=>2, 'KiB'=>1, 'B'=>0];

    public function __construct($numberOfBytes, $precision = self::NORMAL_PRECISION)
    {
        $scale = new PowerScale(self::$base, self::$suffixes, self::MAXIMUM_PRECISION);
        $formatter = new Formatter($scale, $precision);
        parent::__construct($numberOfBytes, $formatter);
    }

    public static function parser()
    {
        $scale = new PowerScale(self::$base, self::$suffixes, self::MAXIMUM_PRECISION);
        return new Parser($scale, __CLASS__);
    }
}
