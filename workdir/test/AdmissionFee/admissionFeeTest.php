<?php

use App\AdmissionFee\AdmissionFee;
use PHPUnit\Framework\TestCase;

class admissionFeeTest extends TestCase{

    protected function setUp() :void {
        
    }

    /**
     * @test
     * @dataProvider 適切な年齢を設定する用データ
     */
    public function 適切な重さを設定する(
        int $age,
        $expectedValue,
    ) {
        $admissionFee = null;

        try {
            $admissonFeeEntity = new AdmissionFee($age);
            $admissionFee = $admissonFeeEntity->getFee();
        }catch(\InvalidArgumentException $e) {
            $admissionFee = $e->getMessage();
        }

        $this->assertEquals($expectedValue, $admissionFee);
    }

    public static function 適切な年齢を設定する用データ() {
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