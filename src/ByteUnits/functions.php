<?php

namespace ByteUnits;

function bytes($numberOf)
{
    return new Metric($numberOf);
}

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
