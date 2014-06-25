<?php

namespace ByteUnits;

class Metric extends System
{
    private static $base = 1000;
    private static $suffixes = ['YB'=>8, 'ZB'=>7, 'EB'=>6, 'PB'=>5, 'TB'=>4, 'GB'=>3, 'MB'=>2, 'kB'=>1, 'B'=>0];
    private static $scale;
    private static $parser;

    public function __construct($numberOfBytes, $precision = self::NORMAL_PRECISION)
    {
        parent::__construct($numberOfBytes, new Formatter(self::scale(), $precision));
    }

    public static function kilobytes($numberOf)
    {
        return new self(self::scale()->scaleFromUnit($numberOf, 'kB'));
    }

    public static function megabytes($numberOf)
    {
        return new self(self::scale()->scaleFromUnit($numberOf, 'MB'));
    }

    public static function gigabytes($numberOf)
    {
        return new self(self::scale()->scaleFromUnit($numberOf, 'GB'));
    }

    public static function terabytes($numberOf)
    {
        return new self(self::scale()->scaleFromUnit($numberOf, 'TB'));
    }

    public static function petabytes($numberOf)
    {
        return new self(self::scale()->scaleFromUnit($numberOf, 'PB'));
    }

    public static function exabytes($numberOf)
    {
        return new self(self::scale()->scaleFromUnit($numberOf, 'EB'));
    }

    public static function scale()
    {
        return self::$scale = self::$scale ?: new PowerScale(self::$base, self::$suffixes, self::MAXIMUM_PRECISION);
    }

    public static function parser()
    {
        return self::$parser = self::$parser ?: new Parser(self::$scale, __CLASS__);
    }
}
