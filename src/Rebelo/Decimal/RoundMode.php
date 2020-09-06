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

    /**
     * Half up round mode
     */
    const HALF_UP     = 1;
    /**
     * Half down round mode
     */
    const HALF_DOWN   = 2;

    /**
     * Half up even mode
     */
    const HALF_EVEN   = 3;

    /**
     * Half odd round mode
     */
    const HALF_ODD    = 4;

    /**
     * Truncate
     */
    const TRUNCATE    = - 1;

    /**
     * No round mode
     */
    const UNNECESSARY = - 2;

    /**
     *
     * @param int|string $value
     * @throws \Rebelo\Enum\EnumException
     */
    public function __construct($value) /** @phpstan-ignore-line */
    {
        parent::__construct($value);
    }

    /**
     * Get the Round mode value
     * @return int
     */
    public function get(): int
    {
        return (int) parent::get();
    }
}
