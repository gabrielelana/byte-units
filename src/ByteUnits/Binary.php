<?php

namespace ByteUnits;

class Binary extends System
{
    private static $base = 1024;
    private static $suffixes = ['YiB'=>8, 'ZiB'=>7, 'EiB'=>6, 'PiB'=>5, 'TiB'=>4, 'GiB'=>3, 'MiB'=>2, 'KiB'=>1, 'B'=>0];
    private static $scale;
    private static $parser;

    public static function kilobytes($numberOf)
    {
        return new self(self::scale()->scaleFromUnit($numberOf, 'KiB'));
    }

    public static function megabytes($numberOf)
    {
        return new self(self::scale()->scaleFromUnit($numberOf, 'MiB'));
    }

    public static function gigabytes($numberOf)
    {
        return new self(self::scale()->scaleFromUnit($numberOf, 'GiB'));
    }

    public static function terabytes($numberOf)
    {
        return new self(self::scale()->scaleFromUnit($numberOf, 'TiB'));
    }

    public static function petabytes($numberOf)
    {
        return new self(self::scale()->scaleFromUnit($numberOf, 'PiB'));
    }

    public static function exabytes($numberOf)
    {
        return new self(self::scale()->scaleFromUnit($numberOf, 'EiB'));
    }

    public function __construct($numberOfBytes, $formatWithPrecision = self::DEFAULT_FORMAT_PRECISION)
    {
        parent::__construct($numberOfBytes, new Formatter(self::scale(), $formatWithPrecision));
    }

    public static function scale()
    {
        return self::$scale = self::$scale ?: new PowerScale(self::$base, self::$suffixes, self::COMPUTE_WITH_PRECISION);
    }

    public static function parser()
    {
        return self::$parser = self::$parser ?: new Parser(self::scale(), __CLASS__);
    }
}
