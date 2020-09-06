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
     * @return Mixed return the php native variavel type
     */
    public function valueOf();

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

    /**
     *
     * Return a string representing the object
     *
     * @return string Description
     */
    public function serialize(): string;

    /**
     *
     * unserialize a obj string previous serialized
     * @param string $serialized the string serialized
     * @return Mixed Returns this object
     */
    public static function unserialize(string $serialized);
}
