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
 * Decimal number
 * @method Decimal divide(ADecimal|float|int $number, ?int $precision = null, RoundMode $roundMode = null, bool $highCalcPrecision = null)
 * @method Decimal modulus(ADecimal|float|int $number, ?int $precision = null, RoundMode $roundMode = null, bool $highCalcPrecision = null)
 * @method Decimal multiply(ADecimal|float|int $number, ?int $precision = null, RoundMode $roundMode = null, bool $highCalcPrecision = null)
 * @method Decimal plus(ADecimal|float|int $number, ?int $precision = null, RoundMode $roundMode = null, bool $highCalcPrecision = null)
 * @method Decimal subtract(ADecimal|float|int $number, ?int $precision = null, RoundMode $roundMode = null, bool $highCalcPrecision = null)
 * @author João Rebelo
 */
class Decimal extends Base\ADecimal
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
        bool                     $highCalcPrecision = false
    )
    {
        $this->isUnsigned = false;
        parent::__construct($number, $precision, $roundMode, $highCalcPrecision);
    }

    /**
     * @param int|null $precision
     * @param \Rebelo\Decimal\RoundMode|null $roundMode
     * @param bool|null $highCalcPrecision
     * @return \Rebelo\Decimal\UDecimal
     * @throws \Rebelo\Decimal\DecimalException
     * @throws \Rebelo\Enum\EnumException
     */
    public function toUDecimal(
        ?int       $precision = null,
        ?RoundMode $roundMode = null,
        ?bool      $highCalcPrecision = false
    ): UDecimal
    {
        return new UDecimal(
            $this->data,
            $precision ?? $this->precision,
            $roundMode ?? new RoundMode($this->roundMode),
            $highCalcPrecision ?? $this->highCalcPrecision
        );
    }

}
