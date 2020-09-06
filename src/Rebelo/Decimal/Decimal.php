<?php

/**
 * MIT License
 *
 * Copyright (c) 2019 João M F Rebelo
 */
declare(strict_types=1);

namespace Rebelo\Decimal;

use Rebelo\Decimal\RoundMode;

/**
 * Decimal number
 *
 * @author João Rebelo
 */
class Decimal
    extends Base\ADecimal
    implements Base\IDecimal
{

    /**
     *
     * {@inheritdoc}
     *
     * @see \Rebelo\Decimal\Base\ADecimal::__construct()
     */
    public function __construct($number, int $precision,
                                \Rebelo\Decimal\RoundMode $roundMode = null)
    {
        $this->isUnsigned = false;
        parent::__construct($number, $precision, $roundMode);
    }

    /**
     *
     * {@inheritdoc}
     *
     * @param \Rebelo\Decimal\Base\ADecimal|float|int $number
     * @param int|null $precision the decimal part of the number to be rounded
     * @param \Rebelo\Decimal\RoundMode $roundMode the round mode     *
     * @return \Rebelo\Decimal\Decimal
     * @throws \Rebelo\Decimal\DecimalException
     */
    public function divide($number, ?int $precision = null,
                           RoundMode $roundMode = null): Decimal
    {
        return $this->aDivide(
            $number,
            $precision,
            $roundMode
        );
    }

    /**
     * Return a new ADecimal whose the value is the reminder of this demcial divided
     * by $number.
     * If $pecision and/or $roundMode are note suplied is used $this precison or/and
     * $this rooundMode
     *
     * @param \Rebelo\Decimal\Base\ADecimal|float|int $number
     * @param int|null $precision the decimal part of the number to be rounded
     * @param \Rebelo\Decimal\RoundMode $roundMode the round mode
     *
     * @return \Rebelo\Decimal\Decimal
     * @throws \Rebelo\Decimal\DecimalException
     */
    public function modulus($number, ?int $precision = null,
                            RoundMode $roundMode = null): Decimal
    {
        return $this->aModulus(
            $number,
            $precision,
            $roundMode
        );
    }

    /**
     * Return a new ADecimal whose the value is this demcial muliplied by $number
     * if $pecision and/or $roundMode are note suplied is used $this precison or/and
     * $this rooundMode
     *
     * @param \Rebelo\Decimal\Base\ADecimal|float|int $number
     * @param integer $precision the decimal part of the number to be rounded
     * @param \Rebelo\Decimal\RoundMode $roundMode the round mode
     * @return \Rebelo\Decimal\Decimal
     * @throws \Rebelo\Decimal\DecimalException
     */
    public function multiply($number, int $precision = null,
                             RoundMode $roundMode = null): Decimal
    {
        return $this->aMultiply(
            $number,
            $precision,
            $roundMode
        );
    }

    /**
     * Return a new ADecimal whose the value is this demcial plus $number
     * if $pecision and/or $roundMode are note suplied is used $this precison or/and
     * $this rooundMode
     *
     * @param \Rebelo\Decimal\Base\ADecimal|float|int $number
     * @param int|null $precision the decimal part of the number to be rounded
     * @param \Rebelo\Decimal\RoundMode $roundMode the round mode
     *
     * @return \Rebelo\Decimal\Decimal
     * @throws \Rebelo\Decimal\DecimalException
     */
    public function plus($number, ?int $precision = null,
                         \Rebelo\Decimal\RoundMode $roundMode = null): Decimal
    {
        return $this->aPlus(
            $number,
            $precision,
            $roundMode
        );
    }

    /**
     *
     * Return a new Decimal whose the value is this demcial minus $number
     * if $pecision and/or $roundMode are note suplied is used $this precison or/and
     * $this rooundMode
     *
     * @param \Rebelo\Decimal\Base\ADecimal|float|int $number
     * @param int|null $precision the decimal part of the number to be rounded
     * @param \Rebelo\Decimal\RoundMode $roundMode the round mode
     * @return \Rebelo\Decimal\Decimal
     * @throws \Rebelo\Decimal\DecimalException
     */
    public function subtract($number, ?int $precision = null,
                             RoundMode $roundMode = null): Decimal
    {
        return $this->aSubtract(
            $number,
            $precision,
            $roundMode
        );
    }

    /**
     *
     * Unserialize the Decimal object
     *
     * @param string $serialized the seralized Decimal
     * @return Decimal
     */
    public static function unserialize(string $serialized): Decimal
    {
        return \unserialize(
            $serialized,
            [
                "allowed_classes" => [\Rebelo\Decimal\Decimal::class]
            ]
        );
    }

}
