<?php

namespace ByteUnits;

abstract class System
{
    const NORMAL_PRECISION = 2;
    const MAXIMUM_PRECISION = 10;

    protected $formatter;
    protected $numberOfBytes;

    public static function bytes($numberOf, $precision = self::NORMAL_PRECISION)
    {
        return new static($numberOf, $precision);
    }

    public function __construct($numberOfBytes, $formatter)
    {
        $this->formatter = $formatter;
        $this->numberOfBytes = $this->normalize($numberOfBytes);
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
