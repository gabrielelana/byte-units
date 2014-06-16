<?php

namespace ByteUnits;

function bytes($numberOf)
{
    return new Metric($numberOf);
}
