<?php

use App\AdmissionFee\AdmissionFee;
use PHPUnit\Framework\TestCase;

class admissionFeeTest extends TestCase{

    protected function setUp() :void {
        
    }

    /**
     * @test
     * @dataProvider 年齢別の入場料を取得用データ
     */
    public function 年齢別の入場料を取得(
        int $age,
        $expectedValue,
    ) {
        $admissionFee = null;

        try {
            $admissonFeeValueObject = new AdmissionFee($age);
            $admissionFee = $admissonFeeValueObject->getFee();
        }catch(\InvalidArgumentException $e) {
            $admissionFee = $e->getMessage();
        }

        $this->assertEquals($expectedValue, $admissionFee);
    }

    public static function 年齢別の入場料を取得用データ() {
        return [
            [-10, '-'],
            [-1, '-'],
            [0, 0],
            [3, 0],
            [5, 0],
            [6, 500],
            [9, 500],
            [12, 500],
            [13, 1000],
            [15, 1000],
            [17, 1000],
            [18, 1500],
            [60, 1500],
        ];
    }
}