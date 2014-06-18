<?php

namespace ByteUnits;

class Binary extends System
{
    protected $base = 1024;
    protected $suffixes = [
        'YiB' => 8,
        'ZiB' => 7,
        'EiB' => 6,
        'PiB' => 5,
        'TiB' => 4,
        'GiB' => 3,
        'MiB' => 2,
        'KiB' => 1,
        'B' => 0,
    ];
}
