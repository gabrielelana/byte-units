<?php

namespace ByteUnits;

class Metric
{
    const MAX_PRECISION = 10;

    private $numberOfBytes;
    private $precision;

    private $base = 1000;
    private $suffixes = [
        'YB' => 8,
        'ZB' => 7,
        'EB' => 6,
        'PB' => 5,
        'TB' => 4,
        'GB' => 3,
        'MB' => 2,
        'kB' => 1,
        'B' => 0,
    ];

    public static function bytes($numberOf)
    {
        return new self($numberOf);
    }

    public function __construct($numberOfBytes)
    {
        $this->numberOfBytes = $this->normalize($numberOfBytes);
        $this->precision = 2;
    }

    public function format($howToFormat = null)
    {
        $precision = $this->precisionFrom($howToFormat);
        $byteUnit = $this->byteUnitToFormatTo($howToFormat);
        return $this->formatInByteUnit($byteUnit, $precision);
    }

    private function byteUnitToFormatTo($howToFormat)
    {
        if (is_string($howToFormat)) {
            if (preg_match('/^(?P<unit>YB|ZB|EB|PB|TB|GB|MB|kB|B)(?:\/.*$)?/i', $howToFormat, $matches)) {
                if (array_key_exists($matches['unit'], $this->suffixes)) {
                    return $matches['unit'];
                }
            }
        }
        return $this->mostReadableByteUnit();
    }

    private function formatInByteUnit($byteUnit, $precision)
    {
        $scaled = $this->scaleInByteUnit($byteUnit);
        if ($byteUnit === 'B') {
            return sprintf("%d%s", $scaled, $byteUnit);
        }
        return sprintf("%.{$precision}f%s", $scaled, $byteUnit);
    }

    private function mostReadableByteUnit()
    {
        foreach ($this->suffixes as $byteUnit => $_) {
            $scaled = $this->scaleInByteUnit($byteUnit);
            if (bccomp($scaled, 1) >= 0) {
                return $byteUnit;
            }
        }
    }

    private function scaleInByteUnit($byteUnit)
    {
        return $this->div($this->numberOfBytes, $this->base, $this->suffixes[$byteUnit]);
    }

    private function precisionFrom($howToFormat)
    {
        if (is_integer($howToFormat)) {
            return min($howToFormat, self::MAX_PRECISION);
        }
        if (is_string($howToFormat)) {
            if (preg_match('/^.*\/(?<precision>0+)$/', $howToFormat, $matches)) {
                return strlen($matches['precision']);
            }
            if (preg_match('/^.*\/(?<precision>\d+)$/', $howToFormat, $matches)) {
                return intval($matches['precision']);
            }
        }
        return $this->precision;
    }

    private function div($dividend, $base, $power)
    {
        return bcdiv(
            $dividend,
            bcpow($base, $power, self::MAX_PRECISION),
            self::MAX_PRECISION
        );
    }

    private function normalize($numberOfBytes)
    {
        $numberOfBytes = (string) $numberOfBytes;
        if (preg_match('/^(?P<coefficient>\d+(?:\.\d+))E\+(?P<exponent>\d+)$/', $numberOfBytes, $matches)) {
            $numberOfBytes = bcmul(
                $matches['coefficient'],
                bcpow($base = 10, $matches['exponent'], self::MAX_PRECISION)
            );
        }
        return $numberOfBytes;
    }
}
