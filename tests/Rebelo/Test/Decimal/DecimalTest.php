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
use Rebelo\Decimal\Decimal;

/**
 * Class DecimalTest
 *
 * This test have a long duration and you have ro set your php max memory
 * to more then 1Gb
 * This test will make 174376 tests and 1734375 assertions
 *
 * @author João Rebelo
 */
class DecimalTest
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

    protected function tearDown()
    {

    }

    public function testInstance()
    {
        $expected = \Rebelo\Decimal\Decimal::class;
        $actual   = new \Rebelo\Decimal\Decimal(9, 9,
                                                new RoundMode(RoundMode::HALF_UP));
        $this->assertInstanceOf($expected, $actual);
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
            array(
                -1,
                -2,
                2,
                -3,
                static::$up,
                null,
                null),
            array(
                -1,
                2,
                2,
                1,
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
        $dec    = new \Rebelo\Decimal\Decimal($num, $prec, $roundMode);
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
        $dec    = new \Rebelo\Decimal\Decimal($num, $prec, $roundMode);
        $sum    = $dec->subtract(new \Rebelo\Decimal\Decimal($add, $prec),
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
        $dec    = new \Rebelo\Decimal\Decimal($num, $prec, $roundMode);
        $sum    = $dec->multiply(new \Rebelo\Decimal\Decimal($add, $prec),
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
        $dec    = new \Rebelo\Decimal\Decimal($num, $prec, $roundMode);
        $sum    = $dec->divide(new \Rebelo\Decimal\Decimal($add, $prec),
                                                           $precOper,
                                                           $roundModeOper);
        $actual = $sum->valueOf();
        $this->assertEquals($exp, $actual);
    }

    public function testDivideByZero()
    {
        $this->expectException(\Rebelo\Decimal\DecimalException::class);
        (new Decimal(2, 1))->divide(new Decimal(0, 2));
    }

    public function testModulos()
    {
        $actual = (new Decimal(1, 2))->divide(new Decimal(2, 0))->valueOf();
        $this->assertEquals(0.5, $actual);
    }

    public function testNegativePrecison()
    {
        $this->expectException(\Rebelo\Decimal\DecimalException::class);
        new Decimal(2, -1);
    }

    public function testNegativeHigger()
    {
        $this->expectException(\Rebelo\Decimal\DecimalException::class);
        new Decimal(2, \Rebelo\Decimal\Base\ADecimal::getMaxPrecision() + 1);
    }

    /**
     *
     * @dataProvider providerTestPlus
     */
    public function testPlusThis($num, $add, int $prec, float $exp, $roundMode,
                                 $precOper, $roundModeOper)
    {
        $dec    = new \Rebelo\Decimal\Decimal($num, $prec, $roundMode);
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
        $dec    = new \Rebelo\Decimal\Decimal($num, $prec, $roundMode);
        $dec->subtractThis(new \Rebelo\Decimal\Decimal($add, $prec));
        $actual = $dec->valueOf();
        $this->assertEquals($exp, $actual);
    }

    public function testMultiplyThis()
    {
        $actual = new Decimal(4.5, 2);
        $actual->multiplyThis(new Decimal(2, 2));
        $this->assertEquals(9.0, $actual->valueOf());
    }

    public function testDivideThisByZero()
    {
        $this->expectException(\Rebelo\Decimal\DecimalException::class);
        (new Decimal(4.5, 2))->divideThis(new Decimal(0, 2));
    }

    public function testDivideThis()
    {
        $actual = new Decimal(9, 2);
        $actual->divideThis(new Decimal(2, 2));
        $this->assertEquals(4.5, $actual->valueOf());
    }

    public function floorProvider()
    {
        return array(
            array(
                9.875855,
                9),
            array(
                -1.9,
                -2),
        );
    }

    /**
     * @dataProvider floorProvider
     */
    public function testFloor($number, $expected)
    {
        $actual = (new Decimal($number,
                               \Rebelo\Decimal\Base\ADecimal::getMaxPrecision()))->flor();
        $this->assertEquals($expected, $actual);
    }

    public function ceilProvider()
    {
        return array(
            array(
                9.875855,
                10),
            array(
                -1.9,
                -1),
        );
    }

    /**
     * @dataProvider ceilProvider
     */
    public function testCeil($number, $expected)
    {
        $actual = (new Decimal($number,
                               \Rebelo\Decimal\Base\ADecimal::getMaxPrecision()))->ceil();
        $this->assertEquals($expected, $actual);
    }

    /**
     * PHP float manual:
     * This can lead to confusing results:
     * for example, floor((0.1+0.7)*10)
     * will usually return 7 instead of the expected 8,
     * since the internal representation will be
     * something like 7.9999999999999991118....
     *
     * @link http://php.net/manual/en/language.types.float.php warnig about float
     */
    public function testExamplePhpManual()
    {
        $dec = new Decimal(0.1, 1, new RoundMode(RoundMode::HALF_UP));
        $dec->plusThis(new Decimal(0.7, 1));
        $dec->multiplyThis(new Decimal(10, 0));
        $this->assertEquals(8, $dec->flor());
    }

    public function testCompareBcAdd()
    {
        $maxPre = \Rebelo\Decimal\Decimal::getMaxPrecision();
        $init   = 0;
        $end    = 100;
        $step   = 0.01;
        for ($precision = $maxPre; $precision > 0; $precision--)
        {
            for ($decimals = $maxPre; $decimals >= 0; $decimals--)
            {
                $lInit = $init;
                do
                {
                    if ($decimals === 0)
                    {
                        $sum = "0";
                    }
                    else if ($decimals === 1)
                    {
                        $sum = "0.1";
                    }
                    else
                    {
                        $sum = str_pad("0.", $decimals + 1, "0");
                        $sum .= "1";
                    }
                    $dec    = new \Rebelo\Decimal\Decimal($lInit, $precision,
                                                          new \Rebelo\Decimal\RoundMode(\Rebelo\Decimal\RoundMode::TRUNCATE));
                    $dec->setRoundMode(new \Rebelo\Decimal\RoundMode(\Rebelo\Decimal\RoundMode::TRUNCATE));
                    $right  = new Decimal($sum, $decimals,
                                          new \Rebelo\Decimal\RoundMode(\Rebelo\Decimal\RoundMode::TRUNCATE));
                    $result = $dec->plus($right);
                    $actual = $result->valueOf();

                    $leftNum     = bcadd("0", (string) $lInit, $precision);
                    $rightNumber = bcadd("0", $sum, $decimals);
                    $expected    = floatval(
                        bcadd($leftNum
                            , $rightNumber
                            , $precision)
                    );

                    $msg   = "Decimal($lInit, $precision)->plus($sum,$decimals) = $actual" . PHP_EOL
                        . "$leftNum     = bcadd(\"0\", (string) $lInit, $precision);" . PHP_EOL
                        . "$rightNumber = bcadd(\"0\", $sum, $decimals);" . PHP_EOL
                        . "floatval(bcadd($leftNum, $rightNumber, $precision)) = $expected" . PHP_EOL;
                    //fwrite(STDERR, $msg);
                    $this->assertEquals($expected, $actual, "ERROR: " . $msg,
                                        0.0, $maxPre);
                    $lInit += $step;
                }
                while ($lInit <= $end);
            }
        }
    }

    /**
     *
     * @param float $left
     * @param float $right
     * @param float $result
     * @param int $precision
     * @param int $decimals
     * @dataProvider provideIntensiveSum
     */
    public function testIntensiveSum($left, $right, $result, $precision,
                                     $decimals)
    {
        $actual = (new \Rebelo\Decimal\Decimal($left, $precision))
                ->plus(new \Rebelo\Decimal\Decimal($right, $decimals))->valueOf();

        $msg = \join(";",
                     [
                $left,
                $right,
                $result,
                $precision,
                $decimals]);

        $this->assertEquals($result, $actual, $msg);
    }

    public function provideIntensiveSum()
    {
        include 'decimalsSum.php';
        return $return;
    }

    /**
     *
     * @param float $left
     * @param float $right
     * @param float $result
     * @param int $precision
     * @param int $decimals
     * @dataProvider provideIntensiveSub
     */
    public function testIntensiveSub($left, $right, $result, $precision,
                                     $decimals)
    {
        $actual = (new \Rebelo\Decimal\Decimal($left, $precision))
                ->subtract(new \Rebelo\Decimal\Decimal($right, $decimals))->valueOf();

        $msg = \join
            (";",
             [
                $left,
                $right,
                $result,
                $precision,
                $decimals]);

        $this->assertEquals($result, $actual, $msg);
    }

    public function provideIntensiveSub()
    {
        include 'decimalsSub.php';
        return $return;
    }

    /**
     *
     * @param float $left
     * @param float $right
     * @param float $result
     * @param int $precision
     * @param int $decimals
     * @dataProvider provideIntensiveMul
     */
    public function testIntensiveMul($left, $right, $result, $precision,
                                     $decimals)
    {
        $actual = (new \Rebelo\Decimal\Decimal($left, $precision))
                ->multiply(new \Rebelo\Decimal\Decimal($right, $decimals))->valueOf();

        $msg = \join
            (";",
             [
                $left,
                $right,
                $result,
                $precision,
                $decimals]);

        $this->assertEquals($result, $actual, $msg);
    }

    public function provideIntensiveMul()
    {
        include 'decimalsMul.php';
        return $return;
    }

    /**
     *
     * @param float $left
     * @param float $right
     * @param float $result
     * @param int $precision
     * @param int $decimals
     * @dataProvider provideIntensiveDiv
     */
    public function testIntensiveDiv($left, $right, $result, $precision,
                                     $decimals)
    {
        $actual = (new \Rebelo\Decimal\Decimal($left, $precision))
                ->divide(new \Rebelo\Decimal\Decimal($right, $decimals))->valueOf();

        $msg = \join
            (";",
             [
                $left,
                $right,
                $result,
                $precision,
                $decimals]);

        $this->assertEquals($result, $actual, $msg);
    }

    public function provideIntensiveDiv()
    {
        include 'decimalsDiv.php';
        return $return;
    }

}
