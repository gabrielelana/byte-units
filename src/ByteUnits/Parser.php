<?php

namespace ByteUnits;

use ReflectionClass;

class Parser
{
    private $scale;
    private $system;

    public function __construct($scale, $system)
    {
        $this->scale = $scale;
        $this->system = new ReflectionClass($system);
    }

    /**
     * @param string $quantityWithUnit
     * @return System
     * @throws ParseException
     */
    public function parse($quantityWithUnit)
    {
        if (preg_match('/(?P<quantity>[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?)\W*(?P<unit>.*)/', $quantityWithUnit, $matches)) {
            $quantity = $matches['quantity'];
            if ($this->scale->isKnownUnit($matches['unit'])) {
                $unit = $this->scale->normalizeNameOfUnit($matches['unit']);
                return $this->system->newInstanceArgs([$this->scale->scaleFromUnit($quantity, $unit)]);
            }
            if (empty($matches['unit'])) {
                return $this->system->newInstanceArgs([$quantity]);
            }
        }
        throw new ParseException("'{$quantityWithUnit}' is not a valid byte format");
    }
}
