<?php

namespace ByteUnits;

class Metric extends System
{
    protected $base = 1000;
    protected $suffixes = [
        'YB' => 8,
        'ZB' => 7,
        'EB' => 6,
        'PB' => 5,
        'TB' => 4,
        'GB' => 3,
        'MB' => 2,
        'kB' => 1,
        'B' => 0,
    ];
}
