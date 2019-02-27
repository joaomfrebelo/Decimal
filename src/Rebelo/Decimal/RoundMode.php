<?php

/**
 * MIT License
 *
 * Copyright (c) 2019 João M F Rebelo
 */
declare(strict_types=1);

namespace Rebelo\Decimal;

/**
 * Round mode to be used to the \Rebelo\Decimal\Base\ADecimal
 *
 * @author João Rebelo
 *
 */
class RoundMode
    extends \Rebelo\Enum\AEnum
{

    const HALF_UP     = 1;
    const HALF_DOWN   = 2;
    const HALF_EVEN   = 3;
    const HALF_ODD    = 4;
    const TRUNCATE    = - 1;
    const UNNECESSARY = - 2;

    /**
     *
     * @param Mixed $value
     * @throws \Rebelo\Enum\EnumException
     */
    public function __construct($value)
    {
        parent::__construct($value);
    }

}
