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
 *
 * @author joao
 * @abstract
 */
abstract class AType implements IType
{
    /**
     *
     * Stores the value
     *
     * @var float
     */
    protected $data = null;

    /**
     *
     * Get this object as a serialized string
     *
     * @return string
     * @final
     */
    final public function serialize(): string
    {
        return \serialize($this);
    }

    /**
     *
     * Throws an exception when trying to call the object as a method
     *
     * @throws \BadFunctionCallException
     */
    final public function __invoke(): \Exception
    {
        throw new \Exception();
    }

    /**
     *
     * @return string
     */
    public function __toString(): string
    {
        return \get_class($this).$this->toString()."\n";
    }

    /**
     *
     * @param \Rebelo\Decimal\Base\ADecimal|float|int $number
     * @return float
     * @throws \InvalidArgumentException On invalid argument
     */
    public function numberToFloat($number): float
    {
        switch (true) {
            case $number instanceof \Rebelo\Decimal\Base\ADecimal:
                return $number->valueOf();
            case is_float($number):
            case is_double($number):
            case is_int($number):
                return (float) $number;
            default :
                throw new \InvalidArgumentException("Invalid argument type in ".__METHOD__);
        }
    }
}