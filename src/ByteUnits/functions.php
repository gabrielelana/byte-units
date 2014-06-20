<?php

namespace ByteUnits;

function bytes($numberOf)
{
    return new Metric($numberOf);
}

function parse($bytesAsString)
{
    $parsers = [Metric::parser(), Binary::parser()];
    foreach ($parsers as $parser) {
        try {
            return $parser->parse($bytesAsString);
        } catch (\Exception $e) {
            // do noting, see you later
        }
    }
    throw new \Exception("'{$bytesAsString}' is not a valid byte format");
}
