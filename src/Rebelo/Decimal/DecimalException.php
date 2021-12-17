<?php
/**
 * MIT License
 *
 * Copyright (c) 2019 João M F Rebelo
 */
declare(strict_types=1);

namespace Rebelo\Decimal;

use JetBrains\PhpStorm\Pure;

/**
 * Exception class to be used in Decimal
 */
class DecimalException
    extends \Exception
{

    /**
     * Decimal Exception
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    #[Pure] public function __construct(string     $message = "", int $code = 0,
                                        \Throwable $previous = NULL)
    {
        parent::__construct(
            $message,
            $code,
            $previous
        );
    }

}
