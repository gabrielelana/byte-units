<?php

namespace ByteUnits;

abstract class System
{
    const NORMAL_PRECISION = 2;
    const MAXIMUM_PRECISION = 10;

    protected $precision;
    protected $numberOfBytes;
    protected $matchAllKnownByteUnits;
    protected $converter;

    public static function bytes($numberOf, $precision = self::NORMAL_PRECISION)
    {
        return new static($numberOf, $precision);
    }

    public function __construct($numberOfBytes, $precision = self::NORMAL_PRECISION)
    {
        $this->precision = $precision;
        $this->numberOfBytes = $this->normalize($numberOfBytes);
        $this->matchAllKnownByteUnits = implode('|', array_keys($this->suffixes));
        $this->converter = new PowerScale($this->base, $this->suffixes, self::MAXIMUM_PRECISION);
    }

    public function format($howToFormat = null)
    {
        $precision = $this->precisionFrom($howToFormat);
        $byteUnit = $this->byteUnitToFormatTo($howToFormat);
        return $this->formatInByteUnit($byteUnit, $precision);
    }

    public function asBinary()
    {
        return Binary::bytes($this->numberOfBytes);
    }

    public function asMetric()
    {
        return Metric::bytes($this->numberOfBytes);
    }

    private function byteUnitToFormatTo($howToFormat)
    {
        if (is_string($howToFormat)) {
            if (preg_match("/^(?P<unit>[^\/]+)(?:\/.*$)?/i", $howToFormat, $matches)) {
                if ($this->converter->isKnownUnit($matches['unit'])) {
                    return $this->converter->normalizeNameOfUnit($matches['unit']);
                }
            }
        }
        return $this->converter->normalUnitFor($this->numberOfBytes);
    }

    private function formatInByteUnit($byteUnit, $precision)
    {
        $scaled = $this->converter->scaleToUnit($this->numberOfBytes, $byteUnit);
        if ($this->converter->isBaseUnit($byteUnit)) {
            return sprintf("%d%s", $scaled, $byteUnit);
        }
        return sprintf("%.{$precision}f%s", $scaled, $byteUnit);
    }

    private function precisionFrom($howToFormat)
    {
        if (is_integer($howToFormat)) {
            return min($howToFormat, self::MAXIMUM_PRECISION);
        }
        if (is_string($howToFormat)) {
            if (preg_match('/^.*\/(?<precision>0*)$/', $howToFormat, $matches)) {
                return strlen($matches['precision']);
            }
            if (preg_match('/^.*\/(?<precision>\d+)$/', $howToFormat, $matches)) {
                return intval($matches['precision']);
            }
        }
        return $this->precision;
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
