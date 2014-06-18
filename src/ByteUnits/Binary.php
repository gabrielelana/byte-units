<?php

namespace ByteUnits;

class Binary
{
    public static function bytes($numberOf)
    {
        return new self($numberOf);
    }

    public function __construct($numberOfBytes)
    {
        $this->numberOfBytes = $this->normalize($numberOfBytes);
        $this->precision = 2;
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
