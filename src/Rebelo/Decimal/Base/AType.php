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
abstract class AType
    implements IType
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
        return \get_class($this) . $this->toString() . "\n";
    }

}
