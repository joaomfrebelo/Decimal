<?php

/**
 * MIT License
 *
 * Copyright (c) 2019 João M F Rebelo
 */
declare(strict_types=1);

namespace Rebelo\Test\Decimal;

use PHPUnit\Framework\TestCase;
use Rebelo\Decimal\RoundMode;
use Rebelo\Decimal\UDecimal;

/**
 * Class UDecimalTest
 *
 * @author João Rebelo
 */
class UDecimalTest
    extends TestCase
{

    static $up;
    static $down;
    static $even;
    static $odd;
    static $truncate;
    static $unnecessary;

    protected function setUp()
    {

    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }

    public function testInstance()
    {
        $expected = \Rebelo\Decimal\UDecimal::class;
        $actual   = new \Rebelo\Decimal\UDecimal(9, 9,
                                                 new RoundMode(RoundMode::HALF_UP));
        $this->assertInstanceOf($expected, $actual);
    }

    public function testNegative()
    {
        $this->expectException(\Rebelo\Decimal\DecimalException::class);
        new UDecimal(-1, 2);
    }

    public function providerTestPlusOper()
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

    public function providerTestPlus()
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
     * @dataProvider providerTestPlusOper
     * @dataProvider providerTestPlus
     */
    public function testPlus($num, $add, int $prec, float $exp, $roundMode,
                             $precOper, $roundModeOper)
    {
        $dec    = new \Rebelo\Decimal\UDecimal($num, $prec, $roundMode);
        $sum    = $dec->plus(new \Rebelo\Decimal\Decimal($add, $prec),
                                                         $precOper,
                                                         $roundModeOper);
        $actual = $sum->valueOf();
        $this->assertEquals($exp, $actual);
    }

    public function providerTestSubtract()
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

    public function providerTestSubtractOper()
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
     * @dataProvider providerTestSubtract
     * @dataProvider providerTestSubtractOper
     */
    public function testSubtract($num, $add, int $prec, float $exp, $roundMode,
                                 $precOper, $roundModeOper)
    {
        $dec    = new \Rebelo\Decimal\UDecimal($num, $prec, $roundMode);
        $sum    = $dec->subtract(new \Rebelo\Decimal\UDecimal($add, $prec),
                                                              $precOper,
                                                              $roundModeOper);
        $actual = $sum->valueOf();
        $this->assertEquals($exp, $actual);
    }

    public function providerTestMultiply()
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
     * @dataProvider providerTestMultiply
     */
    public function testMultiply($num, $add, int $prec, float $exp, $roundMode,
                                 $precOper, $roundModeOper)
    {
        $dec    = new \Rebelo\Decimal\UDecimal($num, $prec, $roundMode);
        $sum    = $dec->multiply(new \Rebelo\Decimal\UDecimal($add, $prec),
                                                              $precOper,
                                                              $roundModeOper);
        $actual = $sum->valueOf();
        $this->assertEquals($exp, $actual);
    }

    public function providerTestDivide()
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
     * @dataProvider providerTestDivide
     */
    public function testDivide($num, $add, int $prec, float $exp, $roundMode,
                               $precOper, $roundModeOper)
    {
        $dec    = new \Rebelo\Decimal\UDecimal($num, $prec, $roundMode);
        $sum    = $dec->divide(new \Rebelo\Decimal\UDecimal($add, $prec),
                                                            $precOper,
                                                            $roundModeOper);
        $actual = $sum->valueOf();
        $this->assertEquals($exp, $actual);
    }

    public function testDivideByZero()
    {
        $this->expectException(\Rebelo\Decimal\DecimalException::class);
        (new UDecimal(2, 1))->divide(new UDecimal(0, 2));
    }

    public function testModulos()
    {
        $actual = (new UDecimal(1, 2))->divide(new UDecimal(2, 0))->valueOf();
        $this->assertEquals(0.5, $actual);
    }

    public function testNegativePrecison()
    {
        $this->expectException(\Rebelo\Decimal\DecimalException::class);
        new UDecimal(2, -1);
    }

    public function testNegativeHigger()
    {
        $this->expectException(\Rebelo\Decimal\DecimalException::class);
        new UDecimal(2, \Rebelo\Decimal\Base\ADecimal::getMaxPrecision() + 1);
    }

    /**
     *
     * @dataProvider providerTestPlus
     */
    public function testPlusThis($num, $add, int $prec, float $exp, $roundMode,
                                 $precOper, $roundModeOper)
    {
        $dec    = new \Rebelo\Decimal\UDecimal($num, $prec, $roundMode);
        $dec->plusThis(new \Rebelo\Decimal\Decimal($add, $prec));
        $actual = $dec->valueOf();
        $this->assertEquals($exp, $actual);
    }

    /**
     *
     * @dataProvider providerTestSubtract
     */
    public function testSubtrstactThis($num, $add, int $prec, float $exp,
                                       $roundMode, $precOper, $roundModeOper)
    {
        $dec    = new \Rebelo\Decimal\UDecimal($num, $prec, $roundMode);
        $dec->subtractThis(new \Rebelo\Decimal\UDecimal($add, $prec));
        $actual = $dec->valueOf();
        $this->assertEquals($exp, $actual);
    }

    public function testMultiplyThis()
    {
        $actual = new UDecimal(4.5, 2);
        $actual->multiplyThis(new UDecimal(2, 2));
        $this->assertEquals(9.0, $actual->valueOf());
    }

    public function testDivideThisByZero()
    {
        $this->expectException(\Rebelo\Decimal\DecimalException::class);
        (new UDecimal(4.5, 2))->divideThis(new UDecimal(0, 2));
    }

    public function testDivideThis()
    {
        $actual = new UDecimal(9, 2);
        $actual->divideThis(new UDecimal(2, 2));
        $this->assertEquals(4.5, $actual->valueOf());
    }

    public function floorProvider()
    {
        return array(
            array(
                9.875855,
                9)
        );
    }

    /**
     * @dataProvider floorProvider
     */
    public function testFloor($number, $expected)
    {
        $actual = (new UDecimal($number,
                                \Rebelo\Decimal\Base\ADecimal::getMaxPrecision()))->flor();
        $this->assertEquals($expected, $actual);
    }

    public function ceilProvider()
    {
        return array(
            array(
                9.875855,
                10),
        );
    }

    /**
     * @dataProvider ceilProvider
     */
    public function testCeil($number, $expected)
    {
        $actual = (new UDecimal($number,
                                \Rebelo\Decimal\Base\ADecimal::getMaxPrecision()))->ceil();
        $this->assertEquals($expected, $actual);
    }

}
