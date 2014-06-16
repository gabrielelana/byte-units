<?php

namespace ByteUnits;

class Metric
{
    private $numberOfBytes;
    private $precision;

    private $base = 1000;
    private $suffixes = [
        8 => 'YB',
        7 => 'ZB',
        6 => 'EB',
        5 => 'PB',
        4 => 'TB',
        3 => 'GB',
        2 => 'MB',
        1 => 'kB',
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
        $formatted = $this->numberOfBytes . 'B';
        foreach ($this->suffixes as $power => $suffix) {
            if (bccomp($number = $this->div($this->numberOfBytes, $this->base, $power), 1) >= 0) {
                $formatted = sprintf("%.{$this->precision}f%s", $number, $suffix);
                break;
            }
        }
        return $formatted;
    }

    private function div($dividend, $base, $power)
    {
        return bcdiv($dividend, bcpow($base, $power, 10), 10);
    }

    private function normalize($numberOfBytes)
    {
        $numberOfBytes = (string) $numberOfBytes;
        if (preg_match('/^(?P<coefficient>\d+(?:\.\d+))E\+(?P<exponent>\d+)$/', $numberOfBytes, $matches)) {
            $numberOfBytes = bcmul($matches['coefficient'], bcpow(10, $matches['exponent'], 10));
        }
        return $numberOfBytes;
    }
}
