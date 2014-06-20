<?php

namespace ByteUnits;

abstract class System
{
    const NORMAL_PRECISION = 2;
    const MAXIMUM_PRECISION = 10;

    protected $precision;
    protected $numberOfBytes;
    protected $formatter;

    public static function bytes($numberOf, $precision = self::NORMAL_PRECISION)
    {
        return new static($numberOf, $precision);
    }

    public function __construct($numberOfBytes, $precision = self::NORMAL_PRECISION)
    {
        $this->precision = $precision;
        $this->numberOfBytes = $this->normalize($numberOfBytes);
        $this->formatter = new Formatter(
            new PowerScale($this->base, $this->suffixes, self::MAXIMUM_PRECISION),
            $this->precision);
    }

    public function format($howToFormat = null)
    {
        return $this->formatter->format($this->numberOfBytes, $howToFormat);
    }

    public function asBinary()
    {
        return Binary::bytes($this->numberOfBytes);
    }

    public function asMetric()
    {
        return Metric::bytes($this->numberOfBytes);
    }

    private function normalize($numberOfBytes)
    {
        $numberOfBytes = (string) $numberOfBytes;
        if (preg_match('/^(?P<coefficient>\d+(?:\.\d+))E\+(?P<exponent>\d+)$/', $numberOfBytes, $matches)) {
            $numberOfBytes = bcmul(
                $matches['coefficient'],
                bcpow($base = 10, $matches['exponent'], self::MAXIMUM_PRECISION)
            );
        }
        return $numberOfBytes;
    }
}
