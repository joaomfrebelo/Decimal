<?php

/**
 * MIT License
 *
 * Copyright (c) 2019 João M F Rebelo
 */
declare(strict_types=1);

namespace Rebelo\Decimal;

/**
 * Exception class to be used in Decimal
 */
class DecimalException
    extends \Exception
{

    public function __construct($message = "", $code = 0,
                                \Throwable $previous = NULL)
    {
        parent::__construct($message,
                            $code,
                            $previous);
    }

}
