## Byte Units [![Build Status](https://travis-ci.org/gabrielelana/byte-units.svg?branch=master)](https://travis-ci.org/gabrielelana/byte-units)
This is a utility component for parsing, formatting, converting and manipulating byte units in various formats.

## Usage
```php
<?php

// Bytes manipulation and formatting with explici precision
echo ByteUnits\parse('1.42MB')->add('256B')->format('kB/0000'); // outputs 1420.2560kB

// Bytes comparison
ByteUnits\parse('1.2GB')->isMoreThan('256MB'); // it's true
```

### Parsing
Right now two unit systems are supported:
* The `Metric` system that is based on a 1000-byte kilobyte and uses standard SI suffixes (`kB`, `MB`, `GB`, `TB`, `PB`, …)
* The `Binary` system that is based on a 1024-byte kilobyte and uses binary suffixes (`KiB`, `MiB`, `GiB`, `TiB`, `PiB`, …)

```php
<?php

// Explicit system selection
echo ByteUnits\Metric::bytes(1000)->format();  // outputs 1.00kB
echo ByteUnits\Binary::bytes(1024)->format();  // outputs 1.00KiB

// Implicit selection through parsing
ByteUnits\parse('1.00kB'); // it's an instance of ByteUnits\Metric

// You can also constraint parsing to a specific system
ByteUnits\Metric::parse('1.00kB'); // it's an instance of ByteUnits\Metric
ByteUnits\Binary::parse('1.00kB'); // throws a ByteUnits\ParseException

// For each systems there are static constructors, one for each supported unit
echo ByteUnits\Metric::bytes(1000)->format();  // outputs 1.00kB
echo ByteUnits\Metric::kilobytes(1)->format();  // outputs 1.00kB
echo ByteUnits\Metric::megabytes(1)->format();  // outputs 1.00MB

// You can switch between systems
echo ByteUnits\Binary::bytes(1024)->asMetric()->format(); // outputs 1.02kB
```

### Formatting
In both systems you can format bytes with an appropriate format string
```php
<?php

// By defaults it tries to format bytes in the most readable unit
echo ByteUnits\bytes(1322000)->format(); // outputs 1.32MB
echo ByteUnits\bytes(132200)->format(); // outputs 132.20kB

// You can force the unit using the related suffix
echo ByteUnits\bytes(1322000)->format('MB'); // outputs 1.32MB
echo ByteUnits\bytes(1322000)->format('kB'); // outputs 1322.00kB
echo ByteUnits\bytes(1322000)->format('B'); // outputs 1322000B

// You can choose the precision aka the number of digits after the `.`
echo ByteUnits\bytes(1322123)->format(6); // outputs 1.322123MB
echo ByteUnits\bytes(1322123)->format('/6'); // outputs 1.322123MB
echo ByteUnits\bytes(1322123)->format('MB/6'); // outputs 1.322123MB
echo ByteUnits\bytes(1322123)->format('MB/000000'); // outputs 1.322123MB
echo ByteUnits\bytes(1322123)->format('GB/9'); // outputs 0.001322123GB

// You can specify a separator between then number and the units
echo ByteUnits\bytes(1322000)->format('MB', ' '); // outputs 1.32 MB
echo ByteUnits\bytes(1322000)->format('MB', '/'); // outputs 1.32/MB

// If you don't want to format but get the number of bytes
// NOTE: The output is a string to ensure that there's no overflow
echo ByteUnits\bytes(1322000)->numberOfBytes(); // outputs 1322000
```

### Compare
There are a few methods that could be used to compare bytes in various units and systems
```php
<?php

ByteUnits\Metric::kilobytes(1)->isLessThan(ByteUnits\Binary::kilobytes(1)); // it's true
ByteUnits\Metric::kilobytes(1)->isEqualTo(ByteUnits\Binary::bytes(1000)); // it's true
ByteUnits\Metric::kilobytes(1.3)->isGreaterThan(ByteUnits\Binary::kilobytes(1)); // it's true
```

### Manipulate
Also you can add or remove bytes in various units and systems
```php
<?php

echo ByteUnits\Binary::kilobytes(1)->remove(ByteUnits\Metric::kilobytes(1))->format(); // outputs 24B

// Arithmetic operations always preserves the receiving unit system
echo ByteUnits\Binary::kilobytes(1)->add(ByteUnits\Metric::kilobytes(1))->format(); // outputs 1.98KiB

// You cannot have negative bytes
ByteUnits\Metric::kilobytes(1)->remove(ByteUnits\Binary::kilobytes(1))->format(); // throws ByteUnits\NegativeBytesException
```

### Auto Boxing
Most of the methods can take integers or strings and box them to appropriate byte units
```php

ByteUnits\Metric::kilobytes(1)->isLessThan('1KiB'); // it's true
echo ByteUnits\Binary::kilobytes(1)->remove('1KiB')->format(); // outputs 24B
```

## Installation via [Composer](http://getcomposer.org/)

* Install Composer to your project root:
  ```bash
  curl -sS https://getcomposer.org/installer | php
  ```

* Add a `composer.json` file to your project:
  ```json
  {
    "require": {
      "gabrielelana/byte-units": "^0.5"
    }
  }
  ```

* Run the Composer installer:
  ```bash
  php composer.phar install
  ```

## Self-Promotion
If you like this project, then consider to:
* Star the repository on [GitHub](https://github.com/gabrielelana/byte-units)
* Follow me on
  * [Twitter](http://twitter.com/gabrielelana)
  * [GitHub](https://github.com/gabrielelana)
