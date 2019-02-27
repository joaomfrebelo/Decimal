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
 * UDecimal class
 * Unsigned decimal number
 *
 * @author João Rebelo
 */
class UDecimal
    extends Base\ADecimal
    implements Base\IUDecimal
{

    /**
     *
     * {@inheritdoc}
     *
     * @see \Rebelo\Decimal\Base\ADecimal::__construct()
     */
    public function __construct($number, int $precision,
                                RoundMode $roundMode = null)
    {
        $this->isUnsigned = true;
        parent::__construct($number,
                            $precision,
                            $roundMode);
    }

    /**
     * Get a Decimal that if the absolute value of this
     * @return \Rebelo\Decimal\Decimal
     */
    public function abs(): \Rebelo\Decimal\Decimal
    {
        return parent::abs();
    }

    /**
     * Return a new UDecimal whose the value is the reminder of this demcial divided
     * by $number.
     * If $pecision and/or $roundMode are note suplied is used $this precison or/and
     * $this rooundMode
     *
     * @param \Rebelo\Decimal\Base\ADecimal $number
     * @param integer $precision
     * @param \Rebelo\Decimal\RoundMode $roundMode
     * @return \Rebelo\Decimal\UDecimal
     */
    public function modulus(Base\ADecimal $number, int $precision = null,
                            RoundMode $roundMode = null): UDecimal
    {
        return $this->aModulus($number,
                               $precision,
                               $roundMode);
    }

    /**
     * Return a new UDecimal whose the value is this demcial muliplied by $number
     * if $pecision and/or $roundMode are note suplied is used $this precison or/and
     * $this rooundMode
     *
     * @param \Rebelo\Decimal\Base\ADecimal $number
     * @param int $precision
     * @param \Rebelo\Decimal\RoundMode $roundMode
     * @return \Rebelo\Decimal\UDecimal
     */
    public function multiply(Base\ADecimal $number, int $precision = null,
                             RoundMode $roundMode = null): UDecimal
    {
        return $this->aMultiply($number,
                                $precision,
                                $roundMode);
    }

    /**
     * Return a new UDecimal whose the value is this demcial plus $number
     * if $pecision and/or $roundMode are note suplied is used $this precison or/and
     * $this rooundMode
     *
     * @param \Rebelo\Decimal\Base\ADecimal $number
     * @param int $precision
     * @param \Rebelo\Decimal\RoundMode $roundMode
     * @return \Rebelo\Decimal\UDecimal
     */
    public function plus(Base\ADecimal $number, int $precision = null,
                         RoundMode $roundMode = null): UDecimal
    {
        return $this->aPlus($number,
                            $precision,
                            $roundMode);
    }

    /**
     * Return a new UDecimal whose the value is this demcial minus $number
     * if $pecision and/or $roundMode are note suplied is used $this precison or/and
     * $this rooundMode
     *
     * @param \Rebelo\Decimal\Base\ADecimal $number
     * @param integer $precision
     * @param \Rebelo\Decimal\RoundMode $roundMode
     * @return \Rebelo\Decimal\UDecimal
     */
    public function subtract(Base\ADecimal $number, int $precision = null,
                             RoundMode $roundMode = null): UDecimal
    {
        return $this->aSubtract($number,
                                $precision,
                                $roundMode);
    }

    /**
     *  Unserialize the UDecimal object
     * @param string $serialized
     * @return \Rebelo\Decimal\UDecimal
     */
    public static function unserialize(string $serialized): UDecimal
    {
        return \unserialize($serialized,
                            [
                "allowed_classes" => \Rebelo\Decimal\UDecimal::class
        ]);
    }

    /**
     * Return a new Decimal whose the value is this demcial divided by $number
     * if $pecision and/or $roundMode are note suplied is used $this precison or/and
     * $this rooundMode
     *
     * @param \Rebelo\Decimal\Base\ADecimal $number
     * @param int $precision
     * @param RoundMode $roundMode
     * @return \Rebelo\Decimal\UDecimal
     */
    public function divide(Base\ADecimal $number, int $precision = null,
                           RoundMode $roundMode = null): UDecimal
    {
        return $this->aDivide($number,
                              $precision,
                              $roundMode);
    }

}
