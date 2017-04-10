<?php

namespace ByteUnits;

class Metric extends System
{
    private static $base = 1000;
    private static $suffixes = ['YB'=>8, 'ZB'=>7, 'EB'=>6, 'PB'=>5, 'TB'=>4, 'GB'=>3, 'MB'=>2, 'kB'=>1, 'B'=>0];
    private static $scale;
    private static $parser;

    public function __construct($numberOfBytes, $formatWithPrecision = self::DEFAULT_FORMAT_PRECISION)
    {
        parent::__construct($numberOfBytes, new Formatter(self::scale(), $formatWithPrecision));
    }

    /**
     * @param int $numberOf
     * @return Metric
     */
    public static function kilobytes($numberOf)
    {
        return new self(self::scale()->scaleFromUnit($numberOf, 'kB'));
    }

    /**
     * @param int $numberOf
     * @return Metric
     */
    public static function megabytes($numberOf)
    {
        return new self(self::scale()->scaleFromUnit($numberOf, 'MB'));
    }

    /**
     * @param int $numberOf
     * @return Metric
     */
    public static function gigabytes($numberOf)
    {
        return new self(self::scale()->scaleFromUnit($numberOf, 'GB'));
    }

    /**
     * @param int $numberOf
     * @return Metric
     */
    public static function terabytes($numberOf)
    {
        return new self(self::scale()->scaleFromUnit($numberOf, 'TB'));
    }

    /**
     * @param int $numberOf
     * @return Metric
     */
    public static function petabytes($numberOf)
    {
        return new self(self::scale()->scaleFromUnit($numberOf, 'PB'));
    }

    /**
     * @param int $numberOf
     * @return Metric
     */
    public static function exabytes($numberOf)
    {
        return new self(self::scale()->scaleFromUnit($numberOf, 'EB'));
    }

    /**
     * @return PowerScale
     */
    public static function scale()
    {
        return self::$scale = self::$scale ?: new PowerScale(self::$base, self::$suffixes, self::COMPUTE_WITH_PRECISION);
    }

    /**
     * @return Parser
     */
    public static function parser()
    {
        return self::$parser = self::$parser ?: new Parser(self::scale(), __CLASS__);
    }
}
