<?php

namespace ByteUnits;

use Exception;

function box($something)
{
    if (is_integer($something)) {
        return bytes($something);
    }
    if (is_string($something)) {
        return parse($something);
    }
    if (is_object($something) && ($something instanceof System)) {
        return $something;
    }
    throw new ConversionException();
}

function bytes($numberOf)
{
    return new Metric($numberOf);
}

/**
 * @param $bytesAsString
 * @return System
 * @throws Exception
 */
function parse($bytesAsString)
{
    $lastParseException = null;
    $parsers = [Metric::parser(), Binary::parser()];
    foreach ($parsers as $parser) {
        try {
            return $parser->parse($bytesAsString);
        } catch (\Exception $e) {
            $lastParseException = $e;
        }
    }
    throw $lastParseException;
}
