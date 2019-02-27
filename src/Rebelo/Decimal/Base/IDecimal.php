<?php

/**
 * MIT License
 *
 * Copyright (c) 2019 João M F Rebelo
 */
declare(strict_types=1);

namespace Rebelo\Decimal\Base;

/**
 *
 * @author João Rebelo
 */
interface IDecimal
{

    public function divide(ADecimal $number, int $precision = null,
                           \Rebelo\Decimal\RoundMode $roundMode = null): \Rebelo\Decimal\Decimal;

    public function modulus(ADecimal $number, int $precision = null,
                            \Rebelo\Decimal\RoundMode $roundMode = null): \Rebelo\Decimal\Decimal;

    public function multiply(ADecimal $number, int $precision = null,
                             \Rebelo\Decimal\RoundMode $roundMode = null): \Rebelo\Decimal\Decimal;

    public function plus(ADecimal $number, int $precision = null,
                         \Rebelo\Decimal\RoundMode $roundMode = null): \Rebelo\Decimal\Decimal;

    public function subtract(ADecimal $number, int $precision = null,
                             \Rebelo\Decimal\RoundMode $roundMode = null): \Rebelo\Decimal\Decimal;

    public static function unserialize(string $serialized): \Rebelo\Decimal\Decimal;
}
