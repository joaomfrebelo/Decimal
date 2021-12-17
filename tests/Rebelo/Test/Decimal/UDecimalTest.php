<?php

/**
 * MIT License
 *
 * Copyright (c) 2019 João M F Rebelo
 */
declare(strict_types=1);

namespace Rebelo\Test\Decimal;

use PHPUnit\Framework\TestCase;
use Rebelo\Decimal\{Base\ADecimal, DecimalException, RoundMode, UDecimal, Decimal};

/**
 * Class UDecimalTest
 *
 * @author João Rebelo
 */
class UDecimalTest
    extends TestCase
{

    static RoundMode $up;
    static RoundMode $down;
    static RoundMode $even;
    static RoundMode $odd;
    static RoundMode $truncate;
    static RoundMode $unnecessary;

    /**
     *
     * @return void
     * @throws \Rebelo\Decimal\DecimalException
     */
    public function testInstance(): void
    {
        $expected = UDecimal::class;
        $actual   = new UDecimal(9, 9, new RoundMode(RoundMode::HALF_UP));
        $this->assertInstanceOf($expected, $actual);
    }

    /**
     *
     * @return void
     */
    public function testNegative(): void
    {
        $this->expectException(DecimalException::class);
        new UDecimal(-1, 2);
    }

    /**
     *
     * @return array
     */
    public function providerTestPlusOper(): array
    {
        static::$up          = new RoundMode(RoundMode::HALF_UP);
        static::$down        = new RoundMode(RoundMode::HALF_DOWN);
        static::$even        = new RoundMode(RoundMode::HALF_EVEN);
        static::$odd         = new RoundMode(RoundMode::HALF_ODD);
        static::$truncate    = new RoundMode(RoundMode::TRUNCATE);
        static::$unnecessary = new RoundMode(RoundMode::UNNECESSARY);

        return array(
            array(
                1.5,
                0.0,
                1,
                2.0,
                static::$unnecessary,
                0,
                static::$up),
            array(
                1,
                0.019,
                2,
                1.02,
                static::$unnecessary,
                2,
                static::$up),
        );
    }

    /**
     *
     * @return array
     */
    public function providerTestPlus(): array
    {
        static::$up          = new RoundMode(RoundMode::HALF_UP);
        static::$down        = new RoundMode(RoundMode::HALF_DOWN);
        static::$even        = new RoundMode(RoundMode::HALF_EVEN);
        static::$odd         = new RoundMode(RoundMode::HALF_ODD);
        static::$truncate    = new RoundMode(RoundMode::TRUNCATE);
        static::$unnecessary = new RoundMode(RoundMode::UNNECESSARY);

        return array(
            //round half_down
            array(
                1.175,
                0.00,
                2,
                1.17,
                static::$down,
                null,
                null),
            //round half_even
            array(
                1.175,
                0.00,
                2,
                1.18,
                static::$even,
                null,
                null),
            array(
                9.5,
                0.00,
                0,
                10.0,
                static::$even,
                null,
                null),
            array(
                8.5,
                0.00,
                0,
                8.0,
                static::$even,
                null,
                null),
            //round half_odd
            array(
                1.175,
                0.00,
                2,
                1.17,
                static::$odd,
                null,
                null),
            array(
                9.5,
                0.00,
                0,
                9.0,
                static::$odd,
                null,
                null),
            array(
                8.5,
                0.00,
                0,
                9.0,
                static::$odd,
                null,
                null),
            //truncate
            array(
                9.42519587,
                0.00,
                3,
                9.425,
                static::$truncate,
                null,
                null),
            array(
                9.1,
                0.00,
                0,
                9.0,
                static::$truncate,
                null,
                null),
            array(
                9.9,
                0.00,
                0,
                9.0,
                static::$truncate,
                null,
                null),
            //round half_up
            array(
                1.175,
                0.00,
                2,
                1.18,
                static::$up,
                null,
                null),
            array(
                9,
                90,
                2,
                99.0,
                static::$up,
                null,
                null),
            array(
                1,
                0.1,
                2,
                1.10,
                static::$up,
                null,
                null),
            array(
                1.1,
                0.1,
                2,
                1.20,
                static::$up,
                null,
                null),
            array(
                1.2,
                0.1,
                2,
                1.30,
                static::$up,
                null,
                null),
            array(
                2.8,
                0.1,
                2,
                2.90,
                static::$up,
                null,
                null),
            array(
                2.9,
                0.1,
                2,
                3.00,
                static::$up,
                null,
                null),
            array(
                4.8,
                0.1,
                2,
                4.90,
                static::$up,
                null,
                null),
            array(
                6.9,
                0.1,
                2,
                7.00,
                static::$up,
                null,
                null),
            array(
                6.9,
                -0.1,
                2,
                6.80,
                static::$up,
                null,
                null),
            array(
                101.21,
                0.5,
                2,
                101.71,
                static::$up,
                null,
                null),
            array(
                101.2192,
                0.5,
                4,
                101.7192,
                static::$up,
                null,
                null),
            array(
                1,
                0.01,
                4,
                1.0100,
                static::$up,
                null,
                null),
            array(
                1.01,
                0.0001,
                4,
                1.0101,
                static::$up,
                null,
                null),
            array(
                1.2547,
                0.1,
                4,
                1.3547,
                static::$up,
                null,
                null),
            array(
                2.895796584,
                0.0001,
                4,
                2.8959,
                static::$up,
                null,
                null),
            array(
                2.9251574475588,
                0.1,
                5,
                3.02516,
                static::$up,
                null,
                null),
            array(
                4.4273,
                0.091,
                4,
                4.5183,
                static::$up,
                null,
                null),
            array(
                6.954,
                0.1,
                3,
                7.054,
                static::$up,
                null,
                null),
            array(
                6.91254,
                -0.1,
                7,
                6.81254,
                static::$up,
                null,
                null),
            array(
                1.777,
                0.0,
                2,
                1.78,
                static::$up,
                null,
                null),
        );
    }

    /**
     * @param float|\Rebelo\Decimal\Base\ADecimal|int $num
     * @param float|\Rebelo\Decimal\Base\ADecimal|int $add
     * @param int $prec
     * @param float $exp
     * @param \Rebelo\Decimal\RoundMode $roundMode
     * @param int|null $precOper
     * @param \Rebelo\Decimal\RoundMode|null $roundModeOper
     * @return void
     * @throws \Rebelo\Decimal\DecimalException
     * @throws \Rebelo\Enum\EnumException
     * @dataProvider providerTestPlusOper
     * @dataProvider providerTestPlus
     */
    public function testPlus(
        float|ADecimal|int $num,
        float|ADecimal|int $add,
        int                $prec,
        float              $exp,
        RoundMode          $roundMode,
        ?int               $precOper,
        ?RoundMode         $roundModeOper): void
    {
        $dec    = new UDecimal($num, $prec, $roundMode);
        $sum    = $dec->plus(
            new Decimal($add, $prec),
            $precOper,
            $roundModeOper
        );
        $actual = $sum->valueOf();
        $this->assertEquals($exp, $actual);
    }

    /**
     *
     * @return array
     */
    public function providerTestSubtract(): array
    {
        static::$up          = new RoundMode(RoundMode::HALF_UP);
        static::$down        = new RoundMode(RoundMode::HALF_DOWN);
        static::$even        = new RoundMode(RoundMode::HALF_EVEN);
        static::$odd         = new RoundMode(RoundMode::HALF_ODD);
        static::$truncate    = new RoundMode(RoundMode::TRUNCATE);
        static::$unnecessary = new RoundMode(RoundMode::UNNECESSARY);

        return array(
            array(
                1.545,
                1.0,
                2,
                0.55,
                static::$up,
                null,
                null),
            array(
                99,
                9,
                2,
                90.0,
                static::$up,
                null,
                null),
        );
    }

    /**
     *
     * @return array
     */
    public function providerTestSubtractOper(): array
    {
        static::$up          = new RoundMode(RoundMode::HALF_UP);
        static::$down        = new RoundMode(RoundMode::HALF_DOWN);
        static::$even        = new RoundMode(RoundMode::HALF_EVEN);
        static::$odd         = new RoundMode(RoundMode::HALF_ODD);
        static::$truncate    = new RoundMode(RoundMode::TRUNCATE);
        static::$unnecessary = new RoundMode(RoundMode::UNNECESSARY);

        return array(
            array(
                1.5,
                0.0,
                1,
                2.0,
                static::$unnecessary,
                0,
                static::$up),
            array(
                2,
                0.019,
                2,
                1.98,
                static::$unnecessary,
                2,
                static::$up),
        );
    }

    /**
     * @param float|\Rebelo\Decimal\Base\ADecimal|int $num
     * @param float|\Rebelo\Decimal\Base\ADecimal|int $add
     * @param int $prec
     * @param float $exp
     * @param \Rebelo\Decimal\RoundMode $roundMode
     * @param int|null $precOper
     * @param \Rebelo\Decimal\RoundMode|null $roundModeOper
     * @return void
     * @dataProvider providerTestSubtract
     * @dataProvider providerTestSubtractOper
     * @throws \Rebelo\Decimal\DecimalException
     * @throws \Rebelo\Enum\EnumException
     */
    public function testSubtract(
        float|ADecimal|int $num,
        float|ADecimal|int $add,
        int                $prec,
        float              $exp,
        RoundMode          $roundMode,
        ?int               $precOper,
        ?RoundMode         $roundModeOper): void
    {
        $dec    = new UDecimal($num, $prec, $roundMode);
        $sum    = $dec->subtract(
            new UDecimal($add, $prec),
            $precOper,
            $roundModeOper
        );
        $actual = $sum->valueOf();
        $this->assertEquals($exp, $actual);
    }

    /**
     *
     * @return void
     * @throws \Rebelo\Decimal\DecimalException
     * @throws \Rebelo\Enum\EnumException
     */
    public function testSignedSubtract(): void
    {
        $dec = new UDecimal(9.99, 2);
        $dec->signedSubtract(10.00);
        $sub = $dec->signedSubtract(10.00);
        $this->assertInstanceOf(Decimal::class, $sub);
        $this->assertEquals(-0.01, $sub->valueOf());
    }

    /**
     *
     * @return array
     */
    public function providerTestMultiply(): array
    {
        static::$up          = new RoundMode(RoundMode::HALF_UP);
        static::$down        = new RoundMode(RoundMode::HALF_DOWN);
        static::$even        = new RoundMode(RoundMode::HALF_EVEN);
        static::$odd         = new RoundMode(RoundMode::HALF_ODD);
        static::$truncate    = new RoundMode(RoundMode::TRUNCATE);
        static::$unnecessary = new RoundMode(RoundMode::UNNECESSARY);

        return array(
            array(
                1.5,
                0.0,
                1,
                0.0,
                static::$unnecessary,
                0,
                static::$up),
            array(
                2,
                0.019,
                2,
                0.04,
                static::$unnecessary,
                2,
                static::$up),
            array(
                1.545,
                1.0,
                2,
                1.55,
                static::$up,
                null,
                null),
            array(
                99,
                1,
                2,
                99.0,
                static::$up,
                null,
                null),
        );
    }

    /**
     * @param float|\Rebelo\Decimal\Base\ADecimal|int $num
     * @param float|\Rebelo\Decimal\Base\ADecimal|int $add
     * @param int $prec
     * @param float $exp
     * @param \Rebelo\Decimal\RoundMode $roundMode
     * @param int|null $precOper
     * @param \Rebelo\Decimal\RoundMode|null $roundModeOper
     * @return void
     * @dataProvider providerTestMultiply
     * @throws \Rebelo\Decimal\DecimalException
     * @throws \Rebelo\Enum\EnumException
     */
    public function testMultiply(
        float|ADecimal|int $num,
        float|ADecimal|int $add,
        int                $prec,
        float              $exp,
        RoundMode          $roundMode,
        ?int               $precOper,
        ?RoundMode         $roundModeOper): void
    {
        $dec    = new UDecimal($num, $prec, $roundMode);
        $sum    = $dec->multiply(
            new UDecimal($add, $prec),
            $precOper,
            $roundModeOper
        );
        $actual = $sum->valueOf();
        $this->assertEquals($exp, $actual);
    }

    /**
     *
     * @return array
     */
    public function providerTestDivide(): array
    {
        static::$up          = new RoundMode(RoundMode::HALF_UP);
        static::$down        = new RoundMode(RoundMode::HALF_DOWN);
        static::$even        = new RoundMode(RoundMode::HALF_EVEN);
        static::$odd         = new RoundMode(RoundMode::HALF_ODD);
        static::$truncate    = new RoundMode(RoundMode::TRUNCATE);
        static::$unnecessary = new RoundMode(RoundMode::UNNECESSARY);

        return array(
            array(
                10,
                2,
                1,
                5.0,
                static::$unnecessary,
                0,
                static::$up),
            array(
                9,
                7,
                2,
                1.29,
                static::$unnecessary,
                2,
                static::$up)
        );
    }

    /**
     * @param float|\Rebelo\Decimal\Base\ADecimal|int $num
     * @param float|\Rebelo\Decimal\Base\ADecimal|int $add
     * @param int $prec
     * @param float $exp
     * @param \Rebelo\Decimal\RoundMode $roundMode
     * @param int|null $precOper
     * @param \Rebelo\Decimal\RoundMode|null $roundModeOper
     * @return void
     * @dataProvider providerTestDivide
     * @throws \Rebelo\Decimal\DecimalException
     * @throws \Rebelo\Enum\EnumException
     */
    public function testDivide(
        float|ADecimal|int $num,
        float|ADecimal|int $add,
        int                $prec,
        float              $exp,
        RoundMode          $roundMode,
        ?int               $precOper,
        ?RoundMode         $roundModeOper): void
    {
        $dec    = new UDecimal($num, $prec, $roundMode);
        $sum    = $dec->divide(
            new UDecimal($add, $prec),
            $precOper,
            $roundModeOper
        );
        $actual = $sum->valueOf();
        $this->assertEquals($exp, $actual);
    }

    /**
     *
     * @return void
     * @throws \Rebelo\Enum\EnumException
     */
    public function testDivideByZero(): void
    {
        $this->expectException(DecimalException::class);
        (new UDecimal(2, 1))->divide(new UDecimal(0, 2));
    }

    /**
     *
     * @return void
     * @throws \Rebelo\Decimal\DecimalException
     * @throws \Rebelo\Enum\EnumException
     */
    public function testModulos(): void
    {
        $actual = (new UDecimal(1, 2))->divide(new UDecimal(2, 0))->valueOf();
        $this->assertEquals(0.5, $actual);
    }

    /**
     *
     * @return void
     */
    public function testNegativePrecison(): void
    {
        $this->expectException(DecimalException::class);
        new UDecimal(2, -1);
    }

    /**
     *
     * @return void
     */
    public function testNegativeHigher(): void
    {
        $this->expectException(DecimalException::class);
        new UDecimal(2, ADecimal::getMaxPrecision() + 1);
    }

    /**
     * @param float|\Rebelo\Decimal\Base\ADecimal|int $num
     * @param float|\Rebelo\Decimal\Base\ADecimal|int $add
     * @param int $prec
     * @param float $exp
     * @param \Rebelo\Decimal\RoundMode $roundMode
     * @param int|null $precOper
     * @param \Rebelo\Decimal\RoundMode|null $roundModeOper
     * @return void
     * @dataProvider providerTestPlus
     * @throws \Rebelo\Decimal\DecimalException
     */
    public function testPlusThis(
        float|ADecimal|int $num,
        float|ADecimal|int $add,
        int                $prec,
        float              $exp,
        RoundMode          $roundMode,
        ?int               $precOper,
        ?RoundMode         $roundModeOper): void
    {
        $dec    = new UDecimal($num, $prec, $roundMode);
        $dec->plusThis(new Decimal($add, $prec));
        $actual = $dec->valueOf();
        $this->assertEquals($exp, $actual);
    }

    /**
     * @param float|\Rebelo\Decimal\Base\ADecimal|int $num
     * @param float|\Rebelo\Decimal\Base\ADecimal|int $add
     * @param int $prec
     * @param float $exp
     * @param \Rebelo\Decimal\RoundMode $roundMode
     * @param int|null $precOper
     * @param \Rebelo\Decimal\RoundMode|null $roundModeOper
     * @return void
     * @dataProvider providerTestSubtract
     * @throws \Rebelo\Decimal\DecimalException
     */
    public function testSubtractThis(
        float|ADecimal|int $num,
        float|ADecimal|int $add,
        int                $prec,
        float              $exp,
        RoundMode          $roundMode,
        ?int               $precOper,
        ?RoundMode         $roundModeOper): void
    {
        $dec    = new UDecimal($num, $prec, $roundMode);
        $dec->subtractThis(new UDecimal($add, $prec));
        $actual = $dec->valueOf();
        $this->assertEquals($exp, $actual);
    }

    /**
     *
     * @return void
     * @throws \Rebelo\Decimal\DecimalException
     */
    public function testMultiplyThis(): void
    {
        $actual = new UDecimal(4.5, 2);
        $actual->multiplyThis(new UDecimal(2, 2));
        $this->assertEquals(9.0, $actual->valueOf());
    }

    /**
     *
     * @return void
     */
    public function testDivideThisByZero(): void
    {
        $this->expectException(DecimalException::class);
        (new UDecimal(4.5, 2))->divideThis(new UDecimal(0, 2));
    }

    /**
     *
     * @return void
     * @throws \Rebelo\Decimal\DecimalException
     */
    public function testDivideThis(): void
    {
        $actual = new UDecimal(9, 2);
        $actual->divideThis(new UDecimal(2, 2));
        $this->assertEquals(4.5, $actual->valueOf());
    }

    public function floorProvider(): array
    {
        return array(
            array(
                9.875855,
                9)
        );
    }

    /**
     *
     * @param float $number
     * @param int $expected
     * @return void
     * @dataProvider floorProvider
     * @throws \Rebelo\Decimal\DecimalException
     */
    public function testFloor(float $number, int $expected): void
    {
        $actual = (new UDecimal(
            $number,
            ADecimal::getMaxPrecision()
        ))->flor();
        $this->assertEquals($expected, $actual);
    }

    public function ceilProvider(): array
    {
        return array(
            array(
                9.875855,
                10),
        );
    }

    /**
     *
     * @param float $number
     * @param int $expected
     * @return void
     * @dataProvider ceilProvider
     * @throws \Rebelo\Decimal\DecimalException
     */
    public function testCeil(float $number, int $expected): void
    {
        $actual = (new UDecimal(
            $number,
            ADecimal::getMaxPrecision()
        ))->ceil();
        $this->assertEquals($expected, $actual);
    }

    /**
     *
     * @return void
     * @throws \Rebelo\Decimal\DecimalException
     * @throws \Rebelo\Enum\EnumException
     */
    public function testePolymorphism(): void
    {
        $dec = new UDecimal(1, 2);
        $this->assertSame(9.0, $dec->plus(8)->valueOf());
        $this->assertSame(1.5, $dec->plus(0.5)->valueOf());
        $this->assertSame(5.0, $dec->plus(new Decimal(4, 0))->valueOf());

        $this->assertSame(0.0, $dec->subtract(1)->valueOf());
        $this->assertSame(0.5, $dec->subtract(0.5)->valueOf());
        $this->assertSame(0.5, $dec->subtract(new Decimal(0.5, 2))->valueOf());

        $this->assertSame(2.0, $dec->multiply(2)->valueOf());
        $this->assertSame(0.5, $dec->multiply(0.5)->valueOf());
        $this->assertSame(
            4.0, $dec->multiply(new Decimal(4, 0))->valueOf()
        );

        $this->assertSame(0.5, $dec->divide(2)->valueOf());
        $this->assertSame(2.0, $dec->divide(0.5)->valueOf());
        $this->assertSame(0.5, $dec->divide(new Decimal(2, 0))->valueOf());

        $decA = clone $dec;
        $decA->plusThis(8);
        $this->assertSame(9.0, $decA->valueOf());

        $decB = clone $dec;
        $decB->plusThis(0.5);
        $this->assertSame(1.5, $decB->valueOf());

        $decC = clone $dec;
        $decC->plusThis(new Decimal(4, 0));
        $this->assertSame(5.0, $decC->valueOf());

        $decD = clone $dec;
        $decD->subtractThis(1);
        $this->assertSame(0.0, $decD->valueOf());

        $decE = clone $dec;
        $decE->subtractThis(0.5);
        $this->assertSame(0.5, $decE->valueOf());

        $decF = clone $dec;
        $decF->subtractThis(new Decimal(0.5, 2));
        $this->assertSame(0.5, $decF->valueOf());

        $decG = clone $dec;
        $decG->multiplyThis(2);
        $this->assertSame(2.0, $decG->valueOf());

        $decH = clone $dec;
        $decH->multiplyThis(0.5);
        $this->assertSame(0.5, $decH->valueOf());

        $decI = clone $dec;
        $decI->multiplyThis(new Decimal(4, 0));
        $this->assertSame(4.0, $decI->valueOf());

        $decJ = clone $dec;
        $decJ->divideThis(2);
        $this->assertSame(0.5, $decJ->valueOf());

        $decK = clone $dec;
        $decK->divideThis(0.5);
        $this->assertSame(2.0, $decK->valueOf());

        $decL = clone $dec;
        $decL->divideThis(new Decimal(2, 0));
        $this->assertSame(0.5, $decL->valueOf());

        $this->assertSame(0.0, $dec->modulus(1)->valueOf());
        $this->assertSame(0.0, $dec->modulus(1)->valueOf());
        $this->assertSame(0.0, $dec->modulus(new Decimal(1, 0))->valueOf());

        $this->assertTrue($dec->equals(1));
        $this->assertTrue($dec->equals(1.0));
        $this->assertTrue($dec->equals(clone $dec));

        $this->assertTrue($dec->isEquals(1));
        $this->assertTrue($dec->isEquals(1.0));
        $this->assertTrue($dec->isEquals(clone $dec));

        $this->assertTrue($dec->isLess(5));
        $this->assertTrue($dec->isLess(1.5));
        $this->assertTrue($dec->isLess($dec->plus(0.5)));

        $this->assertTrue($dec->isGreater(0));
        $this->assertTrue($dec->isGreater(0.5));
        $this->assertTrue($dec->isGreater($dec->subtract(0.5)));
    }

    /**
     *
     * @return void
     * @throws \Rebelo\Decimal\DecimalException
     */
    public function testIsGreaterOrEqual() :void
    {
        $num = 9;
        $dec = new UDecimal($num, 2);

        $this->assertTrue($dec->isGreaterOrEqual($num));
        $this->assertTrue($dec->isGreaterOrEqual($num - 0.01));
        $this->assertTrue($dec->isGreaterOrEqual($num - 0.001));
        $this->assertTrue($dec->isGreaterOrEqual($num - 1));

        $this->assertFalse($dec->isGreaterOrEqual($num + 0.001));
        $this->assertFalse($dec->isGreaterOrEqual($num + 0.01));
        $this->assertFalse($dec->isGreaterOrEqual($num + 1.0));
    }

    /**
     *
     * @return void
     * @throws \Rebelo\Decimal\DecimalException
     */
    public function testIsLessOrEqual() :void
    {
        $num = 9;
        $dec = new UDecimal($num, 2);

        $this->assertTrue($dec->isLessOrEqual($num));

        $this->assertFalse($dec->isLessOrEqual($num - 0.01));
        $this->assertFalse($dec->isLessOrEqual($num - 0.001));
        $this->assertFalse($dec->isLessOrEqual($num - 1));

        $this->assertTrue($dec->isLessOrEqual($num + 0.001));
        $this->assertTrue($dec->isLessOrEqual($num + 0.01));
        $this->assertTrue($dec->isLessOrEqual($num + 1.0));
    }

    /**
     * @return void
     * @throws \Rebelo\Decimal\DecimalException
     * @throws \Rebelo\Enum\EnumException
     */
    public function testToDecimal(): void
    {
        $uDecimal = new UDecimal(1.0, 2);
        $decimal = $uDecimal->toDecimal();

        $this->assertInstanceOf(Decimal::class, $decimal);
        $this->assertSame($uDecimal->getRoundMode()->get(), $decimal->getRoundMode()->get());
        $this->assertSame($uDecimal->getPrecision(), $decimal->getPrecision());
        $this->assertSame($uDecimal->valueOf(), $decimal->valueOf());
        $this->assertSame($uDecimal->isHighCalcPrecision(), $decimal->isHighCalcPrecision());
    }

}
