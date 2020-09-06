<?php

/**
 * MIT License
 *
 * Copyright (c) 2019 João M F Rebelo
 */
declare(strict_types=1);

namespace Rebelo\Decimal\Base;

use Rebelo\Decimal\RoundMode;
use Rebelo\Decimal\DecimalException;

/**
 * Object oriented class to use the scalar php datatye float as decimal
 * mantaining the precision
 *
 * If the number to initialize as Decimal have more decimal places that the precision
 * the number is will be rounded to the precison in the constructor and with
 * the RoundMode in the contructor
 *
 *
 * @author joao
 */
abstract class ADecimal
    extends AType
{

    /**
     *
     * Max precision
     *
     * @var ?int
     */
    protected static ?int $maxPrecision = null;

    /**
     *
     * The number of decimals (scale)
     *
     * @var int
     */
    protected int $precision;

    /**
     *
     * The round mode
     *
     * @var int One of the RoundMode constants
     */
    protected int $roundMode;

    /**
     * Define if is an usined instance
     * @var bool|null
     */
    protected ?bool $isUnsigned = null;

    /**
     *
     * The default RoundMode is RoundMode::HALF_UP
     *
     * @param float|double|int|string|\Rebelo\Decimal\Decimal $number
     * @param int $precision the decimal part of the number to be rounded
     * @param \Rebelo\Decimal\RoundMode|null $roundMode the round mode
     * @throws \InvalidArgumentException
     */
    public function __construct($number, int $precision,
                                ?\Rebelo\Decimal\RoundMode $roundMode = null)
    {
        if (is_bool($this->isUnsigned) === false)
        {
            throw new DecimalException("isUnsigned is not defined");
        }

        switch (true)
        {
            case is_int($number):
            case is_double($number):
            case is_float($number):
            case \is_numeric($number):
                $this->data = (float) $number;
                break;
            case $number instanceof ADecimal:
                $this->data = $number->valueOf();
                break;
            default:
                throw new \InvalidArgumentException("Invalid argument type in " . __METHOD__);
        }

        $this->checkPrecision($precision);

        $this->precision = $precision;

        $this->roundMode = $roundMode === null
            ? RoundMode::HALF_UP
            : $roundMode->get();

        $this->round();
    }

    /**
     *  Check if the precision is in the valid tange values
     * @param int $precision The precision to be checked
     * @return void
     * @throws DecimalException Throws on values that are negative or above the defined in maxPrecision
     */
    protected function checkPrecision(int $precision): void
    {
        if ($precision < 0 || $precision > static::getMaxPrecision())
        {
            throw new DecimalException("precision must be an int between 0 and ".static::getMaxPrecision());
        }
    }

    /**
     *
     * Get the Max Precision, depends of the value that is
     * setted in php.ini file, less 2
     *
     * @return int The max precision allowed
     */
    public static function getMaxPrecision(): int
    {
        if (static::$maxPrecision === null) {
            static::$maxPrecision = ((int) ini_get("precision")) - 2;
        }
        return static::$maxPrecision;
    }

    /**
     * Throws DecimalException if is Unsigned and tha value is negative
     *
     * @throws DecimalException
     */
    protected function checkSign(): void
    {
        if ($this->isUnsigned && $this->data < 0)
        {
            throw new DecimalException(
                "Unsigned ".get_called_class()
                ." can not be negative '".$this->data."'"
            );
        }
    }

    /**
     *
     * Create the class to return after aritmetic operation
     *
     * @param float $number
     * @param int $precision
     * @param \Rebelo\Decimal\RoundMode $roundMode
     * @return ADecimal
     */
    protected function afterOperFactory(float $number, int $precision = null,
                                        \Rebelo\Decimal\RoundMode $roundMode = null): ADecimal
    {
        $called = get_class($this);
        return new $called(
            $number,
            $precision === null ? $this->precision : $precision,
            $roundMode === null
            ? new RoundMode($this->roundMode)
            : $roundMode
        );
    }

    /**
     *
     * Get the Decimal as a PHP float scalar type
     *
     * @return float
     */
    public function valueOf(): float
    {
        return \floatval($this->data);
    }

    /**
     *
     * Return a new ADecimal whose the value is this demcial plus $number
     * if $pecision and/or $roundMode are note suplied is used $this precison or/and
     * $this rooundMode
     *
     * @param \Rebelo\Decimal\Base\ADecimal|int|float $number
     * @param int $precision the decimal part of the number to be rounded
     * @param \Rebelo\Decimal\RoundMode $roundMode the round mode     *
     * @return \Rebelo\Decimal\Base\ADecimal The new instance result of operation
     * @throws \Rebelo\Decimal\DecimalException
     */
    protected function aPlus($number, ?int $precision = null,
                             \Rebelo\Decimal\RoundMode $roundMode = null): ADecimal
    {
        $oper = $this->data + $this->numberToFloat($number);
        return $this->afterOperFactory($oper, $precision, $roundMode);
    }

    /**
     * Return a new Decimal whose the value is this demcial minus $number
     * if $pecision and/or $roundMode are note suplied is used $this precison or/and
     * $this rooundMode
     *
     * @param \Rebelo\Decimal\Base\ADecimal|float|int $number The number to subtract
     * @param int|null $precision the decimal part of the number to be rounded
     * @param \Rebelo\Decimal\RoundMode $roundMode|null the round mode
     * @return \Rebelo\Decimal\Base\ADecimal The new instance result of operation
     * @throws \Rebelo\Decimal\DecimalException
     */
    protected function aSubtract($number, ?int $precision = null,
                                 ?\Rebelo\Decimal\RoundMode $roundMode = null): ADecimal
    {
        $oper = $this->data - $this->numberToFloat($number);
        return $this->afterOperFactory($oper, $precision, $roundMode);
    }

    /**
     * Return a new ADecimal whose the value is this demcial muliplied by $number
     * if $pecision and/or $roundMode are note suplied is used $this precison or/and
     * $this rooundMode
     *
     * @param \Rebelo\Decimal\Base\ADecimal|float|int $number
     * @param int|null $precision the decimal part of the number to be rounded
     * @param \Rebelo\Decimal\RoundMode $roundMode  the round mode
     * @return \Rebelo\Decimal\Base\ADecimal
     * @throws \Rebelo\Decimal\DecimalException
     */
    protected function aMultiply($number, ?int $precision = null,
                                 \Rebelo\Decimal\RoundMode $roundMode = null): ADecimal
    {
        $oper = $this->data * $this->numberToFloat($number);
        return $this->afterOperFactory($oper, $precision, $roundMode);
    }

    /**
     * Return a new Decimal whose the value is this demcial divided by $number
     * if $pecision and/or $roundMode are note suplied is used $this precison or/and
     * $this rooundMode
     *
     * @param \Rebelo\Decimal\Base\ADecimal|float|int $number
     * @param int|null $precision the decimal part of the number to be rounded
     * @param \Rebelo\Decimal\RoundMode $roundMode the round mode
     * @return \Rebelo\Decimal\Base\ADecimal The new instance result of operation
     * @throws \Rebelo\Decimal\DecimalException
     */
    protected function aDivide($number, ?int $precision = null,
                               \Rebelo\Decimal\RoundMode $roundMode = null): ADecimal
    {
        $valueOf = $this->numberToFloat($number);
        if ($valueOf === 0.0) {
            throw new DecimalException("Can not divide by zero in " . get_called_class());
        }
        $oper = $this->data / $valueOf;
        return $this->afterOperFactory($oper, $precision, $roundMode);
    }

    /**
     * Return a new ADecimal whose the value is the reminder of this demcial divided
     * by $number.
     * If $pecision and/or $roundMode are note suplied is used $this precison or/and
     * $this rooundMode
     *
     * @param \Rebelo\Decimal\Base\ADecimal|float|int $number
     * @param int|null $precision the decimal part of the number to be rounded
     * @param \Rebelo\Decimal\RoundMode $roundMode The round mode to be used the round mode
     * @return \Rebelo\Decimal\Base\ADecimal The new instance result of operation
     * @throws \Rebelo\Decimal\DecimalException
     */
    protected function aModulus($number, ?int $precision = null,
                                \Rebelo\Decimal\RoundMode $roundMode = null): ADecimal
    {
        $valueOf = $this->numberToFloat($number);
        if ($valueOf === 0.0) {
            throw new DecimalException("Can not modulus of division by zero in " . get_called_class());
        }
        $oper = $this->data % $valueOf;
        return $this->afterOperFactory($oper, $precision, $roundMode);
    }

    /**
     * Add to this decimal the $number
     *
     * @param \Rebelo\Decimal\Base\ADecimal|float|int $number
     * @return void
     * @throws \Rebelo\Decimal\DecimalException
     */
    public function plusThis($number): void
    {
        $this->data += $this->numberToFloat($number);
        $this->round();
    }

    /**
     * Subtract to this decimal the $number
     *
     * @param \Rebelo\Decimal\Base\ADecimal|float|int $number
     * @return void
     * @throws \Rebelo\Decimal\DecimalException
     */
    public function subtractThis($number): void
    {
        $this->data -= $this->numberToFloat($number);
        $this->round();
    }

    /**
     * Multiply to this decimal to $number
     *
     * @param \Rebelo\Decimal\Base\ADecimal|float|int $number
     * @return void
     * @throws \Rebelo\Decimal\DecimalException
     */
    public function multiplyThis($number): void
    {
        $this->data *= $this->numberToFloat($number);
        $this->round();
    }

    /**
     * Divide to this decimal the $number
     *
     * @param \Rebelo\Decimal\Base\ADecimal|float|int $number
     * @return void
     * @throws \Rebelo\Decimal\DecimalException
     */
    public function divideThis($number): void
    {
        $valueOf = $this->numberToFloat($number);
        if ($valueOf === 0.0) {
            throw new DecimalException("Can not divide by zero in " . get_called_class());
        }
        $this->data /= $valueOf;
        $this->round();
    }

    /**
     *
     * Return a new Decimal whose the value is the absolute value of this Decimal
     *
     * @return \Rebelo\Decimal\Decimal
     */
    public function abs(): \Rebelo\Decimal\Decimal
    {
        return new \Rebelo\Decimal\Decimal(
            \abs($this->data), $this->precision, new RoundMode($this->roundMode)
        );
    }

    /**
     *
     * Get the Decimal value as string
     *
     * @return string
     */
    public function toString(): string
    {
        return (string) $this->data;
    }

    /**
     * Roun this decimal
     */
    public function round(): void
    {
        $this->checkSign();
        if ($this->roundMode === RoundMode::UNNECESSARY)
        {
            return;
        }

        if ($this->roundMode === RoundMode::TRUNCATE)
        {
            $fstr = "$this->data";
            if (\preg_match("/E/", $fstr) === 1)
            {
                $fstr = \number_format(
                    $this->data, static::$maxPrecision, ".", ""
                );
            }
            $this->data = (float) \bcadd("0", $fstr, $this->precision);
            return;
        }

        for ($x = static::$maxPrecision + 2; $x >= $this->precision; $x--) {
            $this->data = \round($this->data, $x, $this->roundMode);
        }

        return;
    }

    /**
     *
     * @return string
     */
    public function __toString(): string
    {
        if ($this->data === null)
        {
            throw new \Rebelo\Decimal\DecimalException("Null value in " . get_called_class());
        }
        return (string) $this->toString();
    }

    /**
     * Verify if the two Numbers are equals
     *
     * @param \Rebelo\Decimal\Base\ADecimal|float|int $number
     * @return bool
     */
    public function equals($number): bool
    {
        return $this->valueOf() === $this->numberToFloat($number);
    }

    /**
     * Verify if the two Numbers are equals<br>
     * Alias of equals
     * @param \Rebelo\Decimal\Base\ADecimal|float|int $number
     * @return bool
     */
    public function isEquals($number): bool
    {
        return $this->equals($number);
    }

    /**
     *
     * Compare the two ADecimals
     *
     * if this ADecimal is less return -1
     * if this ADecimal is equals return 0
     * if this ADecimal is grater return 1
     *
     * @param \Rebelo\Decimal\Base\ADecimal|float|int $number
     * @return int
     */
    public function compare($number): int
    {
        return $this->valueOf() <=> $this->numberToFloat($number);
    }

    /**
     *
     * Returns true if this Adecimal is less
     *
     * @param \Rebelo\Decimal\Base\ADecimal|float|int $number
     * @return bool
     */
    public function isLess($number): bool
    {
        return $this->compare($number) === - 1;
    }

    /**
     *
     * Returns true if this Adecimal is greater
     *
     * @param \Rebelo\Decimal\Base\ADecimal|float|int $number
     * @return bool
     */
    public function isGreater($number): bool
    {
        return $this->compare($number) === 1;
    }

    /**
     * Get the RoudMode
     *
     * @return RoundMode
     */
    public function getRounMode(): RoundMode
    {
        return new RoundMode($this->roundMode);
    }

    /**
     *
     * Get precision
     *
     * @return int
     */
    public function getPrecision(): int
    {
        return $this->precision;
    }

    /**
     * Rteurn false if the number doesn't have decomal
     * part or is equal to zero
     *
     * @return bool
     */
    public function hasDecimalPart(): bool
    {
        return ($this->data % 1) !== 0.0;
    }

    /**
     *
     * A int of this decimal value rounded to the next lowest int
     *
     * @return int
     */
    public function flor(): int
    {
        return \intval(\floor($this->data));
    }

    /**
     *
     * A int of this decimal value rounded up to the next highest int
     *
     * @return int
     */
    public function ceil(): int
    {
        return \intval(\ceil($this->data));
    }

    /**
     * Set a new RoundMode to the Decimal calculation
     * Only have efect at next operations
     *
     * @param RoundMode $roundMode
     * @return void
     */
    public function setRoundMode(\Rebelo\Decimal\RoundMode $roundMode): void
    {
        $this->roundMode = $roundMode->get();
    }

    /**
     * Set the precision of the Decimal
     * the Decimal will be Rouded to the new precision
     *
     * @param int $precision
     * @return void
     */
    public function setPrecision(int $precision): void
    {
        $this->checkPrecision($precision);
        $this->precision = $precision;
        $this->round();
        return;
    }

}
