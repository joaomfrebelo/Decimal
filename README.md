# Decimal

Decimal is a library do work with decimals in PHP.
This library has classes to signed and unsigned decimals.

Start on version 4.0 the round method can be high precision or
standard mode, by default is set to standard mode.

The standard mode round precision the decimal using only the first digit after the
last digit of precision, the high precision use all decimals digits.

## Example
``` php
use Rebelo\Decimal\RoundMode;
use Rebelo\Decimal\Decimal;

$decimal = new Decimal(9.9, 4, new RoundMode(RoundMode::HALF_UP));
$result = $decimal->plus(new Decimal(0.1, 2));
$float = $result->valueOf();

// Simple initialization
$decimal = new Decimal(9.9, 4);

// Full initialization set the RoundMode and precion round mode
$decimal = new Decimal(9.9, 4, new RoundMode(RoundMode::HALF_UP), true);

// Difference between standard mode round precision and high precision
// Standard mode
new Decimal(12571.674647, 2, null, false); // will be round to 12571.67
// high precision mode
new Decimal($value, 2, null, true); // will be12571.68
```
## Install

Via Composer

```bash
$ composer require joaomfrebelo/Decimal
```


## License
Copyright (c) 2019 João M F Rebelo

 Permission is hereby granted, free of charge, to any person obtaining a copy
 of this software and associated documentation files (the "Software"), to deal
 in the Software without restriction, including without limitation the rights
 to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 copies of the Software, and to permit persons to whom the Software is
 furnished to do so, subject to the following conditions:

 The above copyright notice and this permission notice shall be included in
 all copies or substantial portions of the Software.

 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 THE SOFTWARE.
