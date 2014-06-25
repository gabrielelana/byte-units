<?php

namespace ByteUnits;

abstract class System
{
    const DEFAULT_FORMAT_PRECISION = 2;
    const COMPUTE_WITH_PRECISION = 10;

    protected $formatter;
    protected $numberOfBytes;

    public static function bytes($numberOf, $formatWithPrecision = self::DEFAULT_FORMAT_PRECISION)
    {
        return new static($numberOf, $formatWithPrecision);
    }

    public static function parse($bytesAsString)
    {
        return static::parser()->parse($bytesAsString);
    }

    public function __construct($numberOfBytes, $formatter)
    {
        $this->formatter = $formatter;
        $this->numberOfBytes = $this->ensureIsNotNegative($this->normalize($numberOfBytes));
    }

    public function add($another)
    {
        return new static(
            bcadd($this->numberOfBytes, box($another)->numberOfBytes, self::COMPUTE_WITH_PRECISION),
            $this->formatter->precision()
        );
    }

    public function remove($another)
    {
        return new static(
            bcsub($this->numberOfBytes, box($another)->numberOfBytes, self::COMPUTE_WITH_PRECISION),
            $this->formatter->precision()
        );
    }

    public function isEqualTo($another)
    {
        return self::compare($this, box($another)) === 0;
    }

    public function isGreaterThanOrEqualTo($another)
    {
        return self::compare($this, box($another)) >= 0;
    }

    public function isGreaterThan($another)
    {
        return self::compare($this, box($another)) > 0;
    }

    public function isLessThanOrEqualTo($another)
    {
        return self::compare($this, box($another)) <= 0;
    }

    public function isLessThan($another)
    {
        return self::compare($this, box($another)) < 0;
    }

    public static function compare($left, $right)
    {
        return bccomp(
            $left->numberOfBytes,
            $right->numberOfBytes,
            self::COMPUTE_WITH_PRECISION
        );
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
                bcpow($base = 10, $matches['exponent'], self::COMPUTE_WITH_PRECISION)
            );
        }
        return $numberOfBytes;
    }

    private function ensureIsNotNegative($numberOfBytes)
    {
        if (bccomp($numberOfBytes, 0) < 0) {
            throw new NegativeBytesException();
        }
        return $numberOfBytes;
    }
}
