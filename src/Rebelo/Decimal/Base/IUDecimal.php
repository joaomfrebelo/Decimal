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
interface IUDecimal
{

    public function divide(ADecimal $number, int $precision = null,
                           \Rebelo\Decimal\RoundMode $roundMode = null): \Rebelo\Decimal\UDecimal;

    public function modulus(ADecimal $number, int $precision = null,
                            \Rebelo\Decimal\RoundMode $roundMode = null): \Rebelo\Decimal\UDecimal;

    public function multiply(ADecimal $number, int $precision = null,
                             \Rebelo\Decimal\RoundMode $roundMode = null): \Rebelo\Decimal\UDecimal;

    public function plus(ADecimal $number, int $precision = null,
                         \Rebelo\Decimal\RoundMode $roundMode = null): \Rebelo\Decimal\UDecimal;

    public function subtract(ADecimal $number, int $precision = null,
                             \Rebelo\Decimal\RoundMode $roundMode = null): \Rebelo\Decimal\UDecimal;

    public static function unserialize(string $serialized): \Rebelo\Decimal\UDecimal;
}
