<?php

namespace ByteUnits;

class Formatter
{
    private $converter;
    private $precision;

    public function __construct($converter, $precision)
    {
        $this->converter = $converter;
        $this->precision = $precision;
    }

    public function precision()
    {
        return $this->precision;
    }

    public function format($numberOfBytes, $howToFormat)
    {
        $precision = $this->precisionFrom($howToFormat);
        $byteUnit = $this->byteUnitToFormatTo($numberOfBytes, $howToFormat);
        return $this->formatInByteUnit($numberOfBytes, $byteUnit, $precision);
    }

    private function precisionFrom($howToFormat)
    {
        if (is_integer($howToFormat)) {
            return $howToFormat;
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

    private function byteUnitToFormatTo($numberOfBytes, $howToFormat)
    {
        if (is_string($howToFormat)) {
            if (preg_match("/^(?P<unit>[^\/]+)(?:\/.*$)?/i", $howToFormat, $matches)) {
                if ($this->converter->isKnownUnit($matches['unit'])) {
                    return $this->converter->normalizeNameOfUnit($matches['unit']);
                }
            }
        }
        return $this->converter->normalUnitFor($numberOfBytes);
    }

    private function formatInByteUnit($numberOfBytes, $byteUnit, $precision)
    {
        $scaled = $this->converter->scaleToUnit($numberOfBytes, $byteUnit);
        if($byteUnit == null) $byteUnit = "B";
        if ($this->converter->isBaseUnit($byteUnit)) {
            return sprintf("%d%s", $scaled, $byteUnit);
        }
        return sprintf("%.{$precision}f%s", $scaled, $byteUnit);
    }
}
