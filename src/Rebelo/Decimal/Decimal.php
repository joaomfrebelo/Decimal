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
 * @method \Rebelo\Decimal\Decimal divide(\Rebelo\Decimal\Base\ADecimal|float|int $number, ?int $precision = null, \Rebelo\Decimal\RoundMode $roundMode = null)
 * @method \Rebelo\Decimal\Decimal modulus(\Rebelo\Decimal\Base\ADecimal|float|int $number, ?int $precision = null, \Rebelo\Decimal\RoundMode $roundMode = null)
 * @method \Rebelo\Decimal\Decimal multiply(\Rebelo\Decimal\Base\ADecimal|float|int $number, ?int $precision = null, \Rebelo\Decimal\RoundMode $roundMode = null)
 * @method \Rebelo\Decimal\Decimal plus(\Rebelo\Decimal\Base\ADecimal|float|int $number, ?int $precision = null, \Rebelo\Decimal\RoundMode $roundMode = null)
 * @method \Rebelo\Decimal\Decimal subtract(\Rebelo\Decimal\Base\ADecimal|float|int $number, ?int $precision = null, \Rebelo\Decimal\RoundMode $roundMode = null)
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
        float|int|string|\Rebelo\Decimal\Decimal $number, 
        int $precision,
        \Rebelo\Decimal\RoundMode $roundMode = null)
    {
        $this->isUnsigned = false;
        parent::__construct($number, $precision, $roundMode);
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
