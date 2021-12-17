<?php
/**
 * MIT License
 *
 * Copyright (c) 2019 João M F Rebelo
 */
declare(strict_types=1);

namespace Rebelo\Decimal\Base;

/**
 *
 * @author João Rebelo
 */
interface IType
{

    /**
     * @return float return the php native variavel type
     */
    public function valueOf(): float;

    /**
     * A string representation of the object
     * @return string
     */
    public function __toString(): string;

    /**
     * Convert the Object to string
     * @return string
     */
    public function toString(): string;

}
