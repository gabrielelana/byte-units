<?php

namespace ByteUnits;

class Binary extends System
{
    private static $base = 1024;
    private static $suffixes = ['YiB'=>8, 'ZiB'=>7, 'EiB'=>6, 'PiB'=>5, 'TiB'=>4, 'GiB'=>3, 'MiB'=>2, 'KiB'=>1, 'B'=>0];
    private static $scale;

    public function __construct($numberOfBytes, $precision = self::NORMAL_PRECISION)
    {
        self::$scale = new PowerScale(self::$base, self::$suffixes, self::MAXIMUM_PRECISION);
        parent::__construct($numberOfBytes, new Formatter(self::$scale, $precision));
    }

    public static function parser()
    {
        return new Parser(self::$scale, __CLASS__);
    }
}
