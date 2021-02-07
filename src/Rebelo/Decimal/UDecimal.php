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
 * @method \Rebelo\Decimal\UDecimal divide(\Rebelo\Decimal\Base\ADecimal|float|int $number, ?int $precision = null, \Rebelo\Decimal\RoundMode $roundMode = null)
 * @method \Rebelo\Decimal\UDecimal modulus(\Rebelo\Decimal\Base\ADecimal|float|int $number, ?int $precision = null, \Rebelo\Decimal\RoundMode $roundMode = null)
 * @method \Rebelo\Decimal\UDecimal multiply(\Rebelo\Decimal\Base\ADecimal|float|int $number, ?int $precision = null, \Rebelo\Decimal\RoundMode $roundMode = null)
 * @method \Rebelo\Decimal\UDecimal plus(\Rebelo\Decimal\Base\ADecimal|float|int $number, ?int $precision = null, \Rebelo\Decimal\RoundMode $roundMode = null)
 * @method \Rebelo\Decimal\UDecimal subtract(\Rebelo\Decimal\Base\ADecimal|float|int $number, ?int $precision = null, \Rebelo\Decimal\RoundMode $roundMode = null)
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
        float|int|string|\Rebelo\Decimal\Decimal $number, 
        int $precision,
        \Rebelo\Decimal\RoundMode $roundMode = null)
    {
        $this->isUnsigned = true;
        parent::__construct($number, $precision, $roundMode);
    }

    /**
     * Return a new Decimal (signed decimal) whose the value is this demcial minus $number
     * if $pecision and/or $roundMode are note suplied is used $this precison or/and
     * $this rooundMode
     *
     * @param \Rebelo\Decimal\Base\ADecimal|float|int $number
     * @param int|null $precision
     * @param \Rebelo\Decimal\RoundMode $roundMode
     * @return \Rebelo\Decimal\Decimal
     */
    public function signedSubtract(
        \Rebelo\Decimal\Base\ADecimal|float|int$number, 
        ?int $precision = null,
        RoundMode $roundMode = null): Decimal
    {
        $dec = new Decimal(
            $this->valueOf(), $this->precision, new RoundMode($this->roundMode)
        );

        return $dec->subtract($number, $precision, $roundMode);
    }

    /**
     * Unserialize the UDecimal object
     * @param string $serialized
     * @return \Rebelo\Decimal\UDecimal
     */
    public static function unserialize(string $serialized): UDecimal
    {
        return \unserialize(
            $serialized,
            [
                "allowed_classes" => [\Rebelo\Decimal\UDecimal::class]
            ]
        );
    }

}