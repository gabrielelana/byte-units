<?php

namespace ByteUnits;

abstract class System
{
    const NORMAL_PRECISION = 2;
    const MAXIMUM_PRECISION = 10;

    public static function bytes($numberOf)
    {
        return new static($numberOf);
    }

    public function __construct($numberOfBytes)
    {
        $this->numberOfBytes = $this->normalize($numberOfBytes);
        $this->precision = self::NORMAL_PRECISION;
    }

    protected function normalize($numberOfBytes)
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
