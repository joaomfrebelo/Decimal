<?php

/**
 * MIT License
 *
 * Copyright (c) 2019 João M F Rebelo
 */

namespace Rebelo\Test\Decimal;

use Rebelo\Decimal\RoundMode;

class RoundModeTest
    extends \PHPUnit\Framework\TestCase
{

    protected \Rebelo\Decimal\RoundMode $_objectValue;
    protected \Rebelo\Decimal\RoundMode $_objectName;

    protected function setUp(): void
    {
        $this->_objectValue = new RoundMode(RoundMode::HALF_EVEN);
        $this->_objectName  = new RoundMode("HALF_EVEN");
    }

    /**
     * @covers \Rebelo\Decimal\RoundMode::get()
     */
    public function testIsValidValueInObjValue(): void
    {
        $this->assertEquals(RoundMode::HALF_EVEN, $this->_objectValue->get());
    }

    /**
     * @covers \Rebelo\Decimal\RoundMode::get()
     */
    public function testIsValidValueInObjName(): void
    {
        $this->assertEquals(RoundMode::HALF_EVEN, $this->_objectValue->get());
    }

    public function testException(): void
    {
        $this->expectException(\Rebelo\Enum\EnumException::class);
        new RoundMode("NOT_EXIST");
    }

}
