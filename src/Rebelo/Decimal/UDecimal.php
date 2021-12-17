<?php
/**
 * MIT License
 *
 * Copyright (c) 2019 João M F Rebelo
 */
declare(strict_types=1);

namespace Rebelo\Decimal;

use Rebelo\Decimal\Base\ADecimal;

/**
 * UDecimal class
 * Unsigned decimal number
 * @method UDecimal divide(ADecimal|float|int $number, ?int $precision = null, RoundMode $roundMode = null, bool $highCalcPrecision = null)
 * @method UDecimal modulus(ADecimal|float|int $number, ?int $precision = null, RoundMode $roundMode = null, bool $highCalcPrecision = null)
 * @method UDecimal multiply(ADecimal|float|int $number, ?int $precision = null, RoundMode $roundMode = null, bool $highCalcPrecision = null)
 * @method UDecimal plus(ADecimal|float|int $number, ?int $precision = null, RoundMode $roundMode = null, bool $highCalcPrecision = null)
 * @method UDecimal subtract(ADecimal|float|int $number, ?int $precision = null, RoundMode $roundMode = null, bool $highCalcPrecision = null)
 *
 * @author João Rebelo
 */
class UDecimal extends Base\ADecimal
{

    /**
     *
     * {@inheritdoc}
     *
     * @see \Rebelo\Decimal\Base\ADecimal::__construct()
     */
    public function __construct(
        float|int|string|Decimal $number,
        int                      $precision,
        RoundMode                $roundMode = null,
        bool                     $highCalcPrecision = false)
    {
        $this->isUnsigned = true;
        parent::__construct($number, $precision, $roundMode, $highCalcPrecision);
    }

    /**
     * Return a new Decimal (signed decimal) who's the value is this decimal minus $number
     * if $precision and/or $roundMode are not supplied is used $this precision or/and
     * $this roundMode
     *
     * @param \Rebelo\Decimal\Base\ADecimal|float|int $number
     * @param int|null $precision
     * @param \Rebelo\Decimal\RoundMode|null $roundMode
     * @param bool|null $highCalcPrecision If true the round meth will use all decimals
     * @return \Rebelo\Decimal\Decimal
     * @throws \Rebelo\Decimal\DecimalException
     * @throws \Rebelo\Enum\EnumException
     */
    public function signedSubtract(
        ADecimal|float|int $number,
        ?int               $precision = null,
        ?RoundMode         $roundMode = null,
        ?bool              $highCalcPrecision = null
    ): Decimal
    {
        $dec = new Decimal(
            $this->valueOf(), $this->precision, new RoundMode($this->roundMode)
        );

        return $dec->subtract($number, $precision, $roundMode, $highCalcPrecision ?? $this->highCalcPrecision);
    }

    /**
     * @param int|null $precision
     * @param \Rebelo\Decimal\RoundMode|null $roundMode
     * @param bool|null $highCalcPrecision
     * @return \Rebelo\Decimal\Decimal
     * @throws \Rebelo\Decimal\DecimalException
     * @throws \Rebelo\Enum\EnumException
     */
    public function toDecimal(
        ?int       $precision = null,
        ?RoundMode $roundMode = null,
        ?bool      $highCalcPrecision = false
    ): Decimal
    {
        return new Decimal(
            $this->data,
            $precision ?? $this->precision,
            $roundMode ?? new RoundMode($this->roundMode),
            $highCalcPrecision ?? $this->highCalcPrecision
        );
    }

}
