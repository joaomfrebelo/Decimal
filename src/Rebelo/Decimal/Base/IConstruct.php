<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
declare(strict_types=1);

namespace Rebelo\Decimal\Base;

use Rebelo\Decimal\Decimal;
use Rebelo\Decimal\RoundMode;

/**
 *
 * @author João Rebelo
 */
interface IConstruct
{
    /**
     *
     * The default RoundMode is RoundMode::HALF_UP
     *
     * @param float|int|string|\Rebelo\Decimal\Decimal $number
     * @param int $precision the decimal part of the number to be rounded
     * @param \Rebelo\Decimal\RoundMode|null $roundMode the round mode
     * @param bool $highCalcPrecision If true the round meth will use all decimals
     * @throws \InvalidArgumentException
     */
    public function __construct(
        float|int|string|Decimal $number,
        int                      $precision,
        ?RoundMode               $roundMode = null,
        bool                     $highCalcPrecision = false
    );
}
