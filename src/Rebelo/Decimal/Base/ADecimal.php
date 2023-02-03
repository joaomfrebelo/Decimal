<?php

/**
 * MIT License
 *
 * Copyright (c) 2019 João M F Rebelo
 */
declare(strict_types=1);

namespace Rebelo\Decimal\Base;

use JetBrains\PhpStorm\Pure;
use Rebelo\Decimal\Decimal;
use Rebelo\Decimal\RoundMode;
use Rebelo\Decimal\DecimalException;

/**
 * Object-oriented class to use the scalar php data type float as decimal
 * maintaining the precision
 *
 * If the number to initialize as Decimal have more decimal places that the precision
 * the number is will be rounded to the precision in the constructor and with
 * the RoundMode in the constructor
 *
 *
 * @author Joao M F Rebelo
 */
abstract class ADecimal extends AType implements IConstruct
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
     * Define if is an unsigned instance
     * @var bool|null
     */
    protected ?bool $isUnsigned = null;

    /**
     * If true the round meth will use all decimals
     * @var bool
     */
    protected bool $highCalcPrecision;

    /**
     *
     * The default RoundMode is RoundMode::HALF_UP
     *
     * @param float|int|string|\Rebelo\Decimal\Decimal $number
     * @param int $precision the decimal part of the number to be rounded
     * @param \Rebelo\Decimal\RoundMode|null $roundMode the round mode
     * @param bool $highCalcPrecision If true the round meth will use all decimals
     * @throws \InvalidArgumentException
     * @throws \Rebelo\Decimal\DecimalException
     */
    public function __construct(
        float|int|string|Decimal $number,
        int                      $precision,
        ?RoundMode               $roundMode = null,
        bool                     $highCalcPrecision = false
    )
    {
        if (is_bool($this->isUnsigned) === false) {
            throw new DecimalException("isUnsigned is not defined");
        }

        $this->data = match (true) {
            \is_numeric($number) => (float)$number,
            $number instanceof ADecimal => $number->valueOf(),
            default => throw new \InvalidArgumentException("Invalid argument type in " . __METHOD__),
        };

        $this->highCalcPrecision = $highCalcPrecision;

        $this->checkPrecision($precision);

        $this->precision = $precision;

        $this->roundMode = $roundMode === null
            ? RoundMode::HALF_UP
            : $roundMode->get();

        $this->round();
    }

    /**
     *  Check if the precision is in the valid range values
     * @param int $precision The precision to be checked
     * @return void
     * @throws DecimalException Throws on values that are negative or above the defined in maxPrecision
     */
    protected function checkPrecision(int $precision): void
    {
        if ($precision < 0 || $precision > static::getMaxPrecision()) {
            throw new DecimalException("precision must be an int between 0 and " . static::getMaxPrecision());
        }
    }

    /**
     *
     * Get the Max Precision, depends on the value that is
     * set in php.ini file, less 2
     *
     * @return int The max precision allowed
     */
    public static function getMaxPrecision(): int
    {
        if (static::$maxPrecision === null) {
            $maxIni = ((int)ini_get("precision")) - 2;
            static::$maxPrecision = min($maxIni, 10);
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
        if ($this->isUnsigned && $this->data < 0) {
            throw new DecimalException(
                "Unsigned " . get_called_class()
                . " can not be negative '" . $this->data . "'"
            );
        }
    }

    /**
     *
     * Create the class to return after arithmetic operation
     *
     * @param float $number
     * @param int|null $precision
     * @param \Rebelo\Decimal\RoundMode|null $roundMode
     * @param bool|null $highCalcPrecision If true the round meth will use all decimals
     * @return static
     * @throws \Rebelo\Decimal\DecimalException
     * @throws \Rebelo\Enum\EnumException
     */
    protected function afterOperationFactory(
        float      $number,
        ?int       $precision = null,
        ?RoundMode $roundMode = null,
        ?bool      $highCalcPrecision = null
    ): static
    {
        return new static(
            $number,
            $precision ?? $this->precision,
            $roundMode ?? new RoundMode($this->roundMode),
            $highCalcPrecision ?? $this->highCalcPrecision
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
        return $this->data;
    }

    /**
     *
     * Return a new ADecimal who's the value is this decimal plus $number
     * if $precision and/or $roundMode are not supplied is used $this precision or/and
     * $this roundMode
     *
     * @param \Rebelo\Decimal\Base\ADecimal|int|float $number
     * @param int|null $precision the decimal part of the number to be rounded
     * @param \Rebelo\Decimal\RoundMode|null $roundMode the round mode
     * @param bool|null $highCalcPrecision If true the round meth will use all decimals
     * @return static The new instance result of operation
     * @throws \Rebelo\Decimal\DecimalException
     * @throws \Rebelo\Enum\EnumException
     */
    public function plus(
        ADecimal|int|float $number,
        ?int               $precision = null,
        ?RoundMode         $roundMode = null,
        ?bool              $highCalcPrecision = null
    ): static
    {
        $result = $this->data + $this->numberToFloat($number);
        return $this->afterOperationFactory($result, $precision, $roundMode, $highCalcPrecision);
    }

    /**
     * Return a new Decimal who's the value is this decimal minus $number
     * if $precision and/or $roundMode are not supplied is used $this precision or/and
     * $this roundMode
     *
     * @param \Rebelo\Decimal\Base\ADecimal|float|int $number The number to subtract
     * @param int|null $precision the decimal part of the number to be rounded
     * @param \Rebelo\Decimal\RoundMode|null $roundMode the round mode
     * @param bool|null $highCalcPrecision If true the round meth will use all decimals
     * @return static The new instance result of operation
     * @throws \Rebelo\Decimal\DecimalException
     * @throws \Rebelo\Enum\EnumException
     */
    public function subtract(
        ADecimal|float|int $number,
        ?int               $precision = null,
        ?RoundMode         $roundMode = null,
        ?bool              $highCalcPrecision = null
    ): static
    {
        $result = $this->data - $this->numberToFloat($number);
        return $this->afterOperationFactory($result, $precision, $roundMode, $highCalcPrecision);
    }

    /**
     * Return a new ADecimal who's the value is this decimal multiplied by $number
     * if $precision and/or $roundMode are not supplied is used $this precision or/and
     * $this roundMode
     *
     * @param \Rebelo\Decimal\Base\ADecimal|float|int $number
     * @param int|null $precision the decimal part of the number to be rounded
     * @param \Rebelo\Decimal\RoundMode|null $roundMode the round mode
     * @param bool|null $highCalcPrecision If true the round meth will use all decimals
     * @return static
     * @throws \Rebelo\Decimal\DecimalException
     * @throws \Rebelo\Enum\EnumException
     */
    public function multiply(
        ADecimal|float|int $number,
        ?int               $precision = null,
        ?RoundMode         $roundMode = null,
        ?bool              $highCalcPrecision = null
    ): static
    {
        $result = $this->data * $this->numberToFloat($number);
        return $this->afterOperationFactory($result, $precision, $roundMode, $highCalcPrecision);
    }

    /**
     * Return a new Decimal who's the value is this decimal divided by $number
     * if $precision and/or $roundMode are not supplied is used $this precision or/and
     * $this roundMode
     *
     * @param \Rebelo\Decimal\Base\ADecimal|float|int $number
     * @param int|null $precision the decimal part of the number to be rounded
     * @param \Rebelo\Decimal\RoundMode|null $roundMode the round mode
     * @param bool|null $highCalcPrecision If true the round meth will use all decimals
     * @return static The new instance result of operation
     * @throws \Rebelo\Decimal\DecimalException
     * @throws \Rebelo\Enum\EnumException
     */
    public function divide(
        ADecimal|float|int $number,
        ?int               $precision = null,
        ?RoundMode         $roundMode = null,
        ?bool              $highCalcPrecision = null
    ): static
    {
        $valueOf = $this->numberToFloat($number);
        if ($valueOf === 0.0) {
            throw new DecimalException("Can not divide by zero in " . get_called_class());
        }
        $result = $this->data / $valueOf;
        return $this->afterOperationFactory($result, $precision, $roundMode, $highCalcPrecision);
    }

    /**
     * Return a new ADecimal who's the value is the reminder of this decimal divided
     * by $number.
     * If $precision and/or $roundMode are not supplied is used $this precision or/and
     * $this roundMode
     *
     * @param \Rebelo\Decimal\Base\ADecimal|float|int $number
     * @param int|null $precision the decimal part of the number to be rounded
     * @param \Rebelo\Decimal\RoundMode|null $roundMode The round mode to be used the round mode
     * @param bool|null $highCalcPrecision If true the round meth will use all decimals
     * @return static The new instance result of operation
     * @throws \Rebelo\Decimal\DecimalException
     * @throws \Rebelo\Enum\EnumException
     */
    public function modulus(
        ADecimal|float|int $number,
        ?int               $precision = null,
        ?RoundMode         $roundMode = null,
        ?bool              $highCalcPrecision = null
    ): static
    {
        $valueOf = $this->numberToFloat($number);
        if ($valueOf === 0.0) {
            throw new DecimalException("Can not modulus of division by zero in " . \get_class($this));
        }
        $result = $this->data % $valueOf;
        return $this->afterOperationFactory($result, $precision, $roundMode, $highCalcPrecision);
    }

    /**
     * Add to this decimal the $number
     *
     * @param \Rebelo\Decimal\Base\ADecimal|float|int $number
     * @return void
     * @throws \Rebelo\Decimal\DecimalException
     */
    public function plusThis(ADecimal|float|int $number): void
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
    public function subtractThis(ADecimal|float|int $number): void
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
    public function multiplyThis(ADecimal|float|int $number): void
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
    public function divideThis(ADecimal|float|int $number): void
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
     * Return a new Decimal who's the value is the absolute value of this Decimal
     *
     * @return \Rebelo\Decimal\Decimal
     * @throws \Rebelo\Decimal\DecimalException
     * @throws \Rebelo\Enum\EnumException
     */
    public function abs(): Decimal
    {
        return new Decimal(
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
        return (string)$this->data;
    }

    /**
     * Round this decimal
     * @return static
     * @throws \Rebelo\Decimal\DecimalException
     */
    public function round(): static
    {
        $this->checkSign();
        if ($this->roundMode === RoundMode::UNNECESSARY) {
            return $this;
        }

        if ($this->roundMode === RoundMode::TRUNCATE) {
            $fstr = "$this->data";
            if (\str_contains($fstr, "E")) {
                $fstr = \number_format(
                    $this->data,
                    static::getMaxPrecision(),
                    ".", ""
                );
            }
            $this->data = (float)\bcadd("0", $fstr, $this->precision);
            return $this;
        }

        if ($this->highCalcPrecision) {
            for ($x = static::$maxPrecision + 2; $x >= $this->precision; $x--) {
                $this->data = \round($this->data, $x, $this->roundMode);
            }
        } else {
            $this->data = \round($this->data, $this->precision, $this->roundMode);
        }

        return $this;
    }

    /**
     *
     * @return string
     */
    #[Pure] public function __toString(): string
    {
        return $this->toString();
    }

    /**
     * Verify if the two Numbers are equals
     *
     * @param \Rebelo\Decimal\Base\ADecimal|float|int $number
     * @return bool
     */
    public function equals(ADecimal|float|int $number): bool
    {
        return $this->valueOf() === $this->numberToFloat($number);
    }

    /**
     * Verify if the two Numbers are equals<br>
     * Alias of equals
     * @param \Rebelo\Decimal\Base\ADecimal|float|int $number
     * @return bool
     */
    public function isEquals(ADecimal|float|int $number): bool
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
    public function compare(ADecimal|float|int $number): int
    {
        return $this->valueOf() <=> $this->numberToFloat($number);
    }

    /**
     *
     * Returns true if this ADecimal is less
     *
     * @param \Rebelo\Decimal\Base\ADecimal|float|int $number
     * @return bool
     */
    public function isLess(ADecimal|float|int $number): bool
    {
        return $this->compare($number) === -1;
    }

    /**
     *
     * Returns true if this ADecimal is less or equal
     *
     * @param \Rebelo\Decimal\Base\ADecimal|float|int $number
     * @return bool
     */
    public function isLessOrEqual(ADecimal|float|int $number): bool
    {
        $compare = $this->compare($number);
        return $compare === -1 || $compare === 0;
    }

    /**
     *
     * Returns true if this ADecimal is greater
     *
     * @param \Rebelo\Decimal\Base\ADecimal|float|int $number
     * @return bool
     */
    public function isGreaterOrEqual(ADecimal|float|int $number): bool
    {
        $compare = $this->compare($number);
        return $compare === 1 || $compare === 0;
    }

    /**
     *
     * Returns true if this ADecimal is greater
     *
     * @param \Rebelo\Decimal\Base\ADecimal|float|int $number
     * @return bool
     */
    public function isGreater(ADecimal|float|int $number): bool
    {
        return $this->compare($number) === 1;
    }

    /**
     * Get the RoundMode
     *
     * @return RoundMode
     * @throws \Rebelo\Enum\EnumException
     */
    public function getRoundMode(): RoundMode
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
     * Return false if the number doesn't have decimal
     * part or is equal to zero
     *
     * @return bool
     */
    public function hasDecimalPart(): bool
    {
        return (float)($this->data % 1) !== 0.0;
    }

    /**
     *
     * An int of this decimal value rounded to the next lowest int
     *
     * @return int
     */
    public function flor(): int
    {
        return \intval(\floor($this->data));
    }

    /**
     *
     * An int of this decimal value rounded up to the next highest int
     *
     * @return int
     */
    public function ceil(): int
    {
        return \intval(\ceil($this->data));
    }

    /**
     * Set a new RoundMode to the Decimal calculation
     * Only have effect at next operations
     *
     * @param RoundMode $roundMode
     * @return static
     */
    public function setRoundMode(RoundMode $roundMode): static
    {
        $this->roundMode = $roundMode->get();
        return $this;
    }

    /**
     * Set the precision of the Decimal.
     * The Decimal will be Rounded to the new precision
     *
     * @param int $precision
     * @return static
     * @throws \Rebelo\Decimal\DecimalException
     */
    public function setPrecision(int $precision): static
    {
        $this->checkPrecision($precision);
        $this->precision = $precision;
        $this->round();
        return $this;
    }

    /**
     * Format the Decimal to a string
     * @param string $decimalSep
     * @param int|null $decimals If nul the precision will be used
     * @param string $thousandsSep
     * @return string
     * @throws DecimalException
     */
    public function format(string $decimalSep = ".", ?int $decimals = null, string $thousandsSep = ""): string
    {
        if ($decimals < 0) {
            throw new DecimalException("Decimals can not be negative");
        }

        $marks = [".", ","];

        if (\in_array($decimalSep, $marks) === false || \in_array($thousandsSep, ["", ...$marks]) === false) {
            throw new DecimalException("Decimal and thousands separator must be '.' or ','");
        }

        return \number_format(
            $this->data,
            $decimals ?? $this->precision,
            $decimalSep,
            $thousandsSep
        );
    }

    /**
     * @return bool
     */
    public function isHighCalcPrecision(): bool
    {
        return $this->highCalcPrecision;
    }

}
