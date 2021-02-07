<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
declare(strict_types=1);

namespace Rebelo\Decimal\Base;

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
     * @throws \InvalidArgumentException
     */
    public function __construct(
        float|int|string|\Rebelo\Decimal\Decimal $number, 
        int $precision,
        ?\Rebelo\Decimal\RoundMode $roundMode = null);
}