<?php
/**
 * MIT License
 *
 * Copyright (c) 2019 João M F Rebelo
 */
declare(strict_types=1);

namespace Rebelo\Test\Decimal;

use PHPUnit\Framework\TestCase;
use Rebelo\Decimal\Base\ADecimal;
use Rebelo\Decimal\DecimalException;
use Rebelo\Decimal\RoundMode;
use Rebelo\Decimal\Decimal;
use Rebelo\Decimal\UDecimal;

/**
 * Class DecimalTest
 *
 * This test has a long duration so you have to set your php max memory
 * to more than 1Gb
 * This test will make 174376 tests and 1734375 assertions
 *
 * @author João Rebelo
 */
class DecimalTest extends TestCase
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
        $expected = Decimal::class;
        $actual   = new Decimal(
            9, 9, new RoundMode(RoundMode::HALF_UP)
        );
        $this->assertInstanceOf($expected, $actual);
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

        return [
            [1.5, 0.0, 1, 2.0, static::$unnecessary, 0, static::$up],
            [1, 0.019, 2, 1.02, static::$unnecessary, 2, static::$up],
        ];
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

        return [
            //round half_down
            [1.175, 0.00, 2, 1.17, static::$down, null, null],
            //round half_even
            [1.175, 0.00, 2, 1.18, static::$even, null, null],
            [9.5, 0.00, 0, 10.0, static::$even, null, null],
            [8.5, 0.00, 0, 8.0, static::$even, null, null],
            //round half_odd
            [1.175, 0.00, 2, 1.17, static::$odd, null, null],
            [9.5, 0.00, 0, 9.0, static::$odd, null, null],
            [8.5, 0.00, 0, 9.0, static::$odd, null, null],
            //truncate
            [9.42519587, 0.00, 3, 9.425, static::$truncate, null, null],
            [9.1, 0.00, 0, 9.0, static::$truncate, null, null],
            [9.9, 0.00, 0, 9.0, static::$truncate, null, null],
            //round half_up
            [1.175, 0.00, 2, 1.18, static::$up, null, null],
            [9, 90, 2, 99.0, static::$up, null, null],
            [1, 0.1, 2, 1.10, static::$up, null, null],
            [1.1, 0.1, 2, 1.20, static::$up, null, null],
            [1.2, 0.1, 2, 1.30, static::$up, null, null],
            [2.8, 0.1, 2, 2.90, static::$up, null, null],
            [2.9, 0.1, 2, 3.00, static::$up, null, null],
            [4.8, 0.1, 2, 4.90, static::$up, null, null],
            [6.9, 0.1, 2, 7.00, static::$up, null, null],
            [6.9, -0.1, 2, 6.80, static::$up, null, null],
            [101.21, 0.5, 2, 101.71, static::$up, null, null],
            [101.2192, 0.5, 4, 101.7192, static::$up, null, null],
            [1, 0.01, 4, 1.0100, static::$up, null, null],
            [1.01, 0.0001, 4, 1.0101, static::$up, null, null],
            [1.2547, 0.1, 4, 1.3547, static::$up, null, null],
            [2.895796584, 0.0001, 4, 2.8959, static::$up, null, null],
            [2.9251574475588, 0.1, 5, 3.02516, static::$up, null, null],
            [4.4273, 0.091, 4, 4.5183, static::$up, null, null],
            [6.954, 0.1, 3, 7.054, static::$up, null, null],
            [6.91254, -0.1, 7, 6.81254, static::$up, null, null],
            [1.777, 0.0, 2, 1.78, static::$up, null, null],
            [-1, -2, 2, -3, static::$up, null, null],
            [-1, 2, 2, 1, static::$up, null, null],
        ];
    }

    /**
     *
     * @param float|\Rebelo\Decimal\Base\ADecimal|int $num
     * @param float|\Rebelo\Decimal\Base\ADecimal|int $add
     * @param int $prec
     * @param float $exp
     * @param \Rebelo\Decimal\RoundMode $roundMode
     * @param int|null $precOper
     * @param \Rebelo\Decimal\RoundMode|null $roundModeOper
     * @return void
     * @dataProvider providerTestPlusOper
     * @dataProvider providerTestPlus
     * @throws \Rebelo\Decimal\DecimalException
     * @throws \Rebelo\Enum\EnumException
     */
    public function testPlus(
        float|ADecimal|int $num,
        float|ADecimal|int $add,
        int                $prec,
        float              $exp,
        RoundMode          $roundMode,
        ?int               $precOper,
        ?RoundMode         $roundModeOper
    ): void
    {
        $dec    = new Decimal($num, $prec, $roundMode);
        $sum    = $dec->plus(
            new Decimal($add, $prec), $precOper, $roundModeOper
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

        return [
            [1.545, 1.0, 2, 0.55, static::$up, null, null],
            [99, 9, 2, 90.0, static::$up, null, null],
        ];
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

        return [
            [1.5, 0.0, 1, 2.0, static::$unnecessary, 0, static::$up],
            [2, 0.019, 2, 1.98, static::$unnecessary, 2, static::$up],
        ];
    }

    /**
     *
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
        $dec    = new Decimal($num, $prec, $roundMode);
        $sum    = $dec->subtract(
            new Decimal($add, $prec), $precOper, $roundModeOper
        );
        $actual = $sum->valueOf();
        $this->assertEquals($exp, $actual);
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

        return [
            [1.5, 0.0, 1, 0.0, static::$unnecessary, 0, static::$up],
            [2, 0.019, 2, 0.04, static::$unnecessary, 2, static::$up],
            [1.545, 1.0, 2, 1.55, static::$up, null, null],
            [99, 1, 2, 99.0, static::$up, null, null],
        ];
    }

    /**
     *
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
        ?RoundMode         $roundModeOper
    ): void
    {
        $dec    = new Decimal($num, $prec, $roundMode);
        $sum    = $dec->multiply(
            new Decimal($add, $prec), $precOper, $roundModeOper
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

        return [
            [10, 2, 1, 5.0, static::$unnecessary, 0, static::$up],
            [9, 7, 2, 1.29, static::$unnecessary, 2, static::$up],
        ];
    }

    /**
     *
     * @param int|float|\Rebelo\Decimal\Base\ADecimal $num
     * @param int|float|\Rebelo\Decimal\Base\ADecimal $add
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
        int|float|ADecimal $num,
        int|float|ADecimal $add,
        int                $prec,
        float              $exp,
        RoundMode          $roundMode,
        ?int               $precOper,
        ?RoundMode         $roundModeOper): void
    {
        $dec    = new Decimal($num, $prec, $roundMode);
        $sum    = $dec->divide(
            new Decimal($add, $prec), $precOper, $roundModeOper
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
        (new Decimal(2, 1))->divide(new Decimal(0, 2));
    }

    /**
     *
     * @return void
     * @throws \Rebelo\Decimal\DecimalException
     * @throws \Rebelo\Enum\EnumException
     */
    public function testModulos(): void
    {
        $actual = (new Decimal(1, 2))->divide(new Decimal(2, 0))->valueOf();
        $this->assertEquals(0.5, $actual);
    }

    /**
     *
     * @return void
     */
    public function testNegativePrecison(): void
    {
        $this->expectException(DecimalException::class);
        new Decimal(2, -1);
    }

    /**
     *
     * @return void
     */
    public function testNegativeHigher(): void
    {
        $this->expectException(DecimalException::class);
        new Decimal(2, ADecimal::getMaxPrecision() + 1);
    }

    /**
     *
     * @param int|float|\Rebelo\Decimal\Base\ADecimal $num
     * @param int|float|\Rebelo\Decimal\Base\ADecimal $add
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
        int|float|ADecimal $num,
        int|float|ADecimal $add,
        int                $prec,
        float              $exp,
        RoundMode          $roundMode,
        ?int               $precOper,
        ?RoundMode         $roundModeOper): void
    {
        $dec = new Decimal($num, $prec, $roundMode);
        $dec->plusThis(new Decimal($add, $prec));
        $actual = $dec->valueOf();
        $this->assertEquals($exp, $actual);
    }

    /**
     * @param int|float|\Rebelo\Decimal\Base\ADecimal $num
     * @param int|float|\Rebelo\Decimal\Base\ADecimal $add
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
        int|float|ADecimal $num,
        int|float|ADecimal $add,
        int                $prec,
        float              $exp,
        RoundMode          $roundMode,
        ?int               $precOper,
        ?RoundMode         $roundModeOper): void
    {
        $dec = new Decimal($num, $prec, $roundMode);
        $dec->subtractThis(new Decimal($add, $prec));
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
        $actual = new Decimal(4.5, 2);
        $actual->multiplyThis(new Decimal(2, 2));
        $this->assertEquals(9.0, $actual->valueOf());
    }

    /**
     *
     * @return void
     */
    public function testDivideThisByZero(): void
    {
        $this->expectException(DecimalException::class);
        (new Decimal(4.5, 2))->divideThis(new Decimal(0, 2));
    }

    /**
     *
     * @return void
     * @throws \Rebelo\Decimal\DecimalException
     */
    public function testDivideThis(): void
    {
        $actual = new Decimal(9, 2);
        $actual->divideThis(new Decimal(2, 2));
        $this->assertEquals(4.5, $actual->valueOf());
    }

    /**
     *
     * @return array
     */
    public function floorProvider(): array
    {
        return [
            [9.875855, 9],
            [-1.9, -2],
        ];
    }

    /**
     *
     * @param float|\Rebelo\Decimal\Base\ADecimal|int $number
     * @param float|\Rebelo\Decimal\Base\ADecimal|int $expected
     * @return void
     * @dataProvider floorProvider
     * @throws \Rebelo\Decimal\DecimalException
     */
    public function testFloor(float|ADecimal|int $number, float|ADecimal|int $expected): void
    {
        $actual = (new Decimal($number, ADecimal::getMaxPrecision()))->flor();
        $this->assertEquals($expected, $actual);
    }

    /**
     *
     * @return array
     */
    public function ceilProvider(): array
    {
        return [
            [9.875855, 10],
            [-1.9, -1],
        ];
    }

    /**
     * @param int|float|\Rebelo\Decimal\Base\ADecimal $number
     * @param int|float|\Rebelo\Decimal\Base\ADecimal $expected
     * @dataProvider ceilProvider
     * @return void
     * @throws \Rebelo\Decimal\DecimalException
     */
    public function testCeil(
        int|float|ADecimal $number,
        int|float|ADecimal $expected
    ): void
    {
        $actual = (new Decimal($number, ADecimal::getMaxPrecision()))->ceil();
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
     * @return void
     * @throws \Rebelo\Decimal\DecimalException
     */
    public function testExamplePhpManual(): void
    {
        $dec = new Decimal(0.1, 1, new RoundMode(RoundMode::HALF_UP));
        $dec->plusThis(new Decimal(0.7, 1));
        $dec->multiplyThis(new Decimal(10, 0));
        $this->assertEquals(8, $dec->flor());
    }

    /**
     * @return void
     * @throws \Rebelo\Decimal\DecimalException
     * @throws \Rebelo\Enum\EnumException
     */
    public function testCompareBcAdd(): void
    {
        $maxPre = Decimal::getMaxPrecision();
        $init   = 0;
        $end    = 100;
        $step   = 0.01;
        for ($precision = $maxPre; $precision > 0; $precision--) {
            for ($decimals = $maxPre; $decimals >= 0; $decimals--) {
                $lInit = $init;
                do {
                    if ($decimals === 0) {
                        $sum = "0";
                    } else if ($decimals === 1) {
                        $sum = "0.1";
                    } else {
                        $sum = str_pad("0.", $decimals + 1, "0");
                        $sum .= "1";
                    }
                    $dec = new Decimal($lInit, $precision, new RoundMode(RoundMode::TRUNCATE));
                    $dec->setRoundMode(new RoundMode(RoundMode::TRUNCATE));
                    $right  = new Decimal($sum, $decimals, new RoundMode(RoundMode::TRUNCATE));
                    $result = $dec->plus($right);
                    $actual = $result->valueOf();

                    $leftNum     = bcadd("0", (string)$lInit, $precision);
                    $rightNumber = bcadd("0", $sum, $decimals);
                    $expected    = floatval(
                        bcadd(
                            $leftNum, $rightNumber, $precision
                        )
                    );

                    $msg = "Decimal($lInit, $precision)->plus($sum,$decimals) = $actual" . PHP_EOL
                           . "$leftNum     = bcadd(\"0\", (string) $lInit, $precision);" . PHP_EOL
                           . "$rightNumber = bcadd(\"0\", $sum, $decimals);" . PHP_EOL
                           . "floatval(bcadd($leftNum, $rightNumber, $precision)) = $expected" . PHP_EOL;
                    //fwrite(STDERR, $msg);
                    $this->assertEquals(
                        $expected, $actual, "ERROR: " . $msg
                    );
                    $lInit += $step;
                } while ($lInit <= $end);
            }
        }
    }

    /**
     *
     * @param float|int $left
     * @param float|int $right
     * @param float $result
     * @param int $precision
     * @param int $decimals
     * @return void
     * @dataProvider provideIntensiveSum
     * @throws \Rebelo\Decimal\DecimalException
     * @throws \Rebelo\Enum\EnumException
     */
    public function testIntensiveSum(
        float|int $left,
        float|int $right,
        float     $result,
        int       $precision,
        int       $decimals): void
    {
        $actual = (new Decimal($left, $precision))
            ->plus(new Decimal($right, $decimals))->valueOf();

        $msg = \join(
            ";",
            [
                $left,
                $right,
                $result,
                $precision,
                $decimals,
            ]
        );

        $this->assertEquals($result, $actual, $msg);
    }

    /**
     *
     * @return array
     */
    public function provideIntensiveSum(): array
    {
        include 'decimalsSum.php';
        //@noinspection all
        return $return; // @phpstan-ignore-line
    }

    /**
     *
     * @param float|int $left
     * @param float|int $right
     * @param float $result
     * @param int $precision
     * @param int $decimals
     * @return void
     * @dataProvider provideIntensiveSub
     * @throws \Rebelo\Decimal\DecimalException
     * @throws \Rebelo\Enum\EnumException
     */
    public function testIntensiveSub(
        float|int $left,
        float|int $right,
        float     $result,
        int       $precision,
        int       $decimals
    ): void
    {
        $actual = (new Decimal($left, $precision))
            ->subtract(new Decimal($right, $decimals))->valueOf();

        $msg = \join(
            ";",
            [
                $left,
                $right,
                $result,
                $precision,
                $decimals]
        );

        $this->assertEquals($result, $actual, $msg);
    }

    /**
     *
     * @return array
     */
    public function provideIntensiveSub(): array
    {
        include 'decimalsSub.php';
        //@noinspection all
        return $return;// @phpstan-ignore-line
    }

    /**
     *
     * @param float $left
     * @param float $right
     * @param float $result
     * @param int $precision
     * @param int $decimals
     * @return void
     * @dataProvider provideIntensiveMul
     * @throws \Rebelo\Decimal\DecimalException
     * @throws \Rebelo\Enum\EnumException
     */
    public function testIntensiveMul(
        float $left,
        float $right,
        float $result,
        int   $precision,
        int   $decimals
    ): void
    {
        $actual = (new Decimal($left, $precision))
            ->multiply(new Decimal($right, $decimals))->valueOf();

        $msg = \join(
            ";",
            [
                $left,
                $right,
                $result,
                $precision,
                $decimals]
        );

        $this->assertEquals($result, $actual, $msg);
    }

    /**
     *
     * @return array
     */
    public function provideIntensiveMul(): array
    {
        include 'decimalsMul.php';
        //@noinspection all
        return $return; //@phpstan-ignore-line
    }

    /**
     *
     * @param float $left
     * @param float $right
     * @param float $result
     * @param int $precision
     * @param int $decimals
     * @return void
     * @dataProvider provideIntensiveDiv
     * @throws \Rebelo\Decimal\DecimalException
     * @throws \Rebelo\Enum\EnumException
     */
    public function testIntensiveDiv(
        float $left,
        float $right,
        float $result,
        int   $precision,
        int   $decimals
    ): void
    {
        $actual = (new Decimal($left, $precision))
            ->divide(new Decimal($right, $decimals))->valueOf();

        $msg = \join(
            ";",
            [
                $left,
                $right,
                $result,
                $precision,
                $decimals]
        );

        $this->assertEquals($result, $actual, $msg);
    }

    /**
     *
     * @return array
     */
    public function provideIntensiveDiv(): array
    {
        include 'decimalsDiv.php';
        //@noinspection all
        return $return; //@phpstan-ignore-line
    }

    /**
     *
     * @return void
     * @throws \Rebelo\Decimal\DecimalException
     * @throws \Rebelo\Enum\EnumException
     */
    public function testPolymorphism(): void
    {
        $dec = new Decimal(1, 2);
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
    public function testIsGreaterOrEqual(): void
    {
        $num = 9;
        $dec = new Decimal($num, 2);

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
    public function testIsLessOrEqual(): void
    {
        $num = 9;
        $dec = new Decimal($num, 2);

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
     */
    public function testHighRoundPrecisionVsNormal()
    {
        $value = 12571.674647;

        $resultConstructStandard = (new Decimal($value, 2, null, false));

        $resultConstructHighCalcPrecision = (new Decimal($value, 2, null, true));

        $resultStandard = (new Decimal($value, 7, null, false))
            ->setPrecision(2);

        $resultHighCalcPrecision = (new Decimal($value, 7, null, true))
            ->setPrecision(2);

        $this->assertSame(12571.67, $resultConstructStandard->valueOf());
        $this->assertSame(12571.68, $resultConstructHighCalcPrecision->valueOf());

        $this->assertSame(12571.67, $resultStandard->valueOf());
        $this->assertSame(12571.68, $resultHighCalcPrecision->valueOf());

    }

    /**
     * @return void
     * @throws \Rebelo\Decimal\DecimalException
     * @throws \Rebelo\Enum\EnumException
     */
    public function testMultiplyHighRoundPrecisionVsNormal()
    {
        $value1 = 11482.03;
        $value2 = 1.0949;

        $resultStandard = (new Decimal($value1, 7, null, false))
            ->multiply($value2)->setPrecision(2)->valueOf();

        $resultHighCalcPrecision = (new Decimal($value1, 7, null, true))
            ->multiply($value2)->setPrecision(2)->valueOf();

        $standardThis = new Decimal($value1, 7, null, false);
        $standardThis->multiplyThis($value2);
        $resultStandardThis = $standardThis->setPrecision(2)->valueOf();

        $highCalcPrecisionThis = new Decimal($value1, 7, null, true);
        $highCalcPrecisionThis->multiplyThis($value2);
        $resultHighCalcPrecisionThis = $highCalcPrecisionThis->setPrecision(2)->valueOf();

        $this->assertSame(12571.67, $resultStandard);
        $this->assertSame(12571.68, $resultHighCalcPrecision);
        $this->assertSame(12571.67, $resultStandardThis);
        $this->assertSame(12571.68, $resultHighCalcPrecisionThis);
    }

    /**
     * @return void
     * @throws \Rebelo\Decimal\DecimalException
     * @throws \Rebelo\Enum\EnumException
     */
    public function testAddHighRoundPrecisionVsNormal()
    {
        $value1 = 12571.67;
        $value2 = 0.004647;

        $resultStandard = (new Decimal($value1, 7, null, false))
            ->plus($value2)->setPrecision(2)->valueOf();

        $resultHighCalcPrecision = (new Decimal($value1, 7, null, true))
            ->plus($value2)->setPrecision(2)->valueOf();

        $standardThis = new Decimal($value1, 7, null, false);
        $standardThis->plusThis($value2);
        $resultStandardThis = $standardThis->setPrecision(2)->valueOf();

        $highCalcPrecisionThis = new Decimal($value1, 7, null, true);
        $highCalcPrecisionThis->plusThis($value2);
        $resultHighCalcPrecisionThis = $highCalcPrecisionThis->setPrecision(2)->valueOf();

        $this->assertSame(12571.67, $resultStandard);
        $this->assertSame(12571.68, $resultHighCalcPrecision);
        $this->assertSame(12571.67, $resultStandardThis);
        $this->assertSame(12571.68, $resultHighCalcPrecisionThis);

    }

    /**
     * @return void
     * @throws \Rebelo\Decimal\DecimalException
     * @throws \Rebelo\Enum\EnumException
     */
    public function testSubtractHighRoundPrecisionVsNormal()
    {
        $value1 = 12571.675647;
        $value2 = 0.001;

        $resultStandard = (new Decimal($value1, 7, null, false))
            ->subtract($value2)->setPrecision(2)->valueOf();

        $resultHighCalcPrecision = (new Decimal($value1, 7, null, true))
            ->subtract($value2)->setPrecision(2)->valueOf();

        $standardThis = new Decimal($value1, 7, null, false);
        $standardThis->subtractThis($value2);
        $resultStandardThis = $standardThis->setPrecision(2)->valueOf();

        $highCalcPrecisionThis = new Decimal($value1, 7, null, true);
        $highCalcPrecisionThis->subtractThis($value2);
        $resultHighCalcPrecisionThis = $highCalcPrecisionThis->setPrecision(2)->valueOf();

        $this->assertSame(12571.67, $resultStandard);
        $this->assertSame(12571.68, $resultHighCalcPrecision);
        $this->assertSame(12571.67, $resultStandardThis);
        $this->assertSame(12571.68, $resultHighCalcPrecisionThis);
    }

    /**
     * @return void
     * @throws \Rebelo\Decimal\DecimalException
     * @throws \Rebelo\Enum\EnumException
     */
    public function testDivideHighRoundPrecisionVsNormal()
    {
        $value1 = 12571.674647;
        $value2 = 1.0;

        $resultStandard = (new Decimal($value1, 7, null, false))
            ->divide($value2)->setPrecision(2)->valueOf();

        $resultHighCalcPrecision = (new Decimal($value1, 7, null, true))
            ->divide($value2)->setPrecision(2)->valueOf();

        $standardThis = new Decimal($value1, 7, null, false);
        $standardThis->divideThis($value2);
        $resultStandardThis = $standardThis->setPrecision(2)->valueOf();

        $highCalcPrecisionThis = new Decimal($value1, 7, null, true);
        $highCalcPrecisionThis->divideThis($value2);
        $resultHighCalcPrecisionThis = $highCalcPrecisionThis->setPrecision(2)->valueOf();

        $this->assertSame(12571.67, $resultStandard);
        $this->assertSame(12571.68, $resultHighCalcPrecision);
        $this->assertSame(12571.67, $resultStandardThis);
        $this->assertSame(12571.68, $resultHighCalcPrecisionThis);
    }

    /**
     * @return void
     * @throws \Rebelo\Decimal\DecimalException
     * @throws \Rebelo\Enum\EnumException
     */
    public function testToUDecimal(): void
    {
        $decimal  = new Decimal(1.0, 2);
        $uDecimal = $decimal->toUDecimal();

        $this->assertInstanceOf(UDecimal::class, $uDecimal);
        $this->assertSame($decimal->getRoundMode()->get(), $uDecimal->getRoundMode()->get());
        $this->assertSame($decimal->getPrecision(), $uDecimal->getPrecision());
        $this->assertSame($decimal->valueOf(), $uDecimal->valueOf());
        $this->assertSame($decimal->isHighCalcPrecision(), $uDecimal->isHighCalcPrecision());
    }

    /**
     * @return void
     * @throws \Rebelo\Decimal\DecimalException
     */
    public function testIsHighCalcPrecision(): void
    {
        $decimal = new Decimal(1.0, 2);
        $this->assertFalse($decimal->isHighCalcPrecision());

        foreach ([true, false] as $bool) {
            $decimal = new Decimal(1.0, 2, null, $bool);
            $this->assertSame($bool, $decimal->isHighCalcPrecision());
        }
    }
}
