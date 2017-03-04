<?php

namespace ByteUnits;

abstract class System
{
    const DEFAULT_FORMAT_PRECISION = 2;
    const COMPUTE_WITH_PRECISION = 10;

    protected $formatter;
    protected $numberOfBytes;

    /**
     * @param int|string $numberOf
     * @param int $formatWithPrecision
     * @return System
     */
    public static function bytes($numberOf, $formatWithPrecision = self::DEFAULT_FORMAT_PRECISION)
    {
        return new static($numberOf, $formatWithPrecision);
    }

    /**
     * @param string $bytesAsString
     * @return System
     */
    public static function parse($bytesAsString)
    {
        return static::parser()->parse($bytesAsString);
    }

    public function __construct($numberOfBytes, $formatter)
    {
        $this->formatter = $formatter;
        $this->numberOfBytes = $this->ensureIsNotNegative($this->normalize($numberOfBytes));
    }

    /**
     * @param System $another
     * @return System
     */
    public function add($another)
    {
        return new static(
            bcadd($this->numberOfBytes, box($another)->numberOfBytes, self::COMPUTE_WITH_PRECISION),
            $this->formatter->precision()
        );
    }

    /**
     * @param System $another
     * @return System
     */
    public function remove($another)
    {
        return new static(
            bcsub($this->numberOfBytes, box($another)->numberOfBytes, self::COMPUTE_WITH_PRECISION),
            $this->formatter->precision()
        );
    }

    /**
     * @param System $another
     * @return bool
     */
    public function isEqualTo($another)
    {
        return self::compare($this, box($another)) === 0;
    }

    /**
     * @param System $another
     * @return bool
     */
    public function isGreaterThanOrEqualTo($another)
    {
        return self::compare($this, box($another)) >= 0;
    }

    /**
     * @param System $another
     * @return bool
     */
    public function isGreaterThan($another)
    {
        return self::compare($this, box($another)) > 0;
    }

    /**
     * @param System $another
     * @return bool
     */
    public function isLessThanOrEqualTo($another)
    {
        return self::compare($this, box($another)) <= 0;
    }

    /**
     * @param System $another
     * @return bool
     */
    public function isLessThan($another)
    {
        return self::compare($this, box($another)) < 0;
    }

    /**
     * @param System $left
     * @param System $right
     * @return int
     */
    public static function compare($left, $right)
    {
        return bccomp(
            $left->numberOfBytes,
            $right->numberOfBytes,
            self::COMPUTE_WITH_PRECISION
        );
    }

    /**
     * @param string $howToFormat
     * @param string $separator
     * @return string
     */
    public function format($howToFormat = null, $separator = '')
    {
        return $this->formatter->format($this->numberOfBytes, $howToFormat, $separator);
    }

    /**
     * @return System
     */
    public function asBinary()
    {
        return Binary::bytes($this->numberOfBytes);
    }

    /**
     * @return System
     */
    public function asMetric()
    {
        return Metric::bytes($this->numberOfBytes);
    }

    /**
     * @param string $numberOfBytes
     * @return int
     */
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

    /**
     * @param int|string $numberOfBytes
     * @return int|string
     * @throws NegativeBytesException
     */
    private function ensureIsNotNegative($numberOfBytes)
    {
        if (bccomp($numberOfBytes, 0) < 0) {
            throw new NegativeBytesException();
        }
        return $numberOfBytes;
    }

    /**
     * @return int|string
     */
    public function numberOfBytes()
    {
        return $this->numberOfBytes;
    }
}
