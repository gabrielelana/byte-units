<?php

namespace ByteUnits;

class PowerScale
{
    private $base;
    private $scale;
    private $precision;

    public function __construct($base, $scale, $precision)
    {
        $this->base = $base;
        $this->scale = $scale;
        $this->precision = $precision;
    }

    public function scaleToUnit($quantity, $unit)
    {
        if ($quantity === "0") return "0";
        return bcdiv(
            $quantity,
            bcpow($this->base, $this->scale[$unit], $this->precision),
            $this->precision
        );
    }

    public function scaleFromUnit($quantity, $unit)
    {
        return $quantity * bcpow(
            $this->base,
            $this->scale[$unit],
            $this->precision
        );
    }

    public function isKnownUnit($unitAsString)
    {
        return preg_match(
            '/^(?:' . implode('|', array_keys($this->scale)) . ')$/i',
            trim($unitAsString)
        );
    }

    public function normalizeNameOfUnit($unitAsString)
    {
        foreach ($this->scale as $unit => $_) {
            if (strtolower($unit) === strtolower($unitAsString)) {
                return $unit;
            }
        }
    }

    public function normalUnitFor($quantity)
    {
        if ($quantity === 0) return "B";
        foreach ($this->scale as $unit => $_) {
            $scaled = $this->scaleToUnit($quantity, $unit);
            if (bccomp($scaled, 1) >= 0) {
                return $unit;
            }
        }
    }

    public function isBaseUnit($unit)
    {
        return (!isset($this->scale[$unit]) || $this->scale[$unit] === 0);
    }
}
