<?php

use App\Bmi\BmiStatus;
use PHPUnit\Framework\TestCase;

class BmiTest extends TestCase{

    protected function setUp() :void {
        
    }

    /**
     * @test
     * @dataProvider Bmiを計算して状態を出力用データ
     */
    public function Bmiを計算して状態を出力(
        float $bmi,
        String $expectedStatus,
    ) {
        $status = null;
        try {
            $bmi = new BmiStatus($bmi);
            $status = $bmi->getNutritionalStatus();
        } catch(\Exception $e) {
            $status = $e->getMessage();
        }

        $this->assertEquals($expectedStatus, $status);
    }

    public static function Bmiを計算して状態を出力用データ() {
        return [
            [-100, '-'],
            [0, '-'],
            [0.1, '痩せ'],
            [15.0, '痩せ'],
            [18.4, '痩せ'],
            [18.5, '普通体重'],
            [20.0, '普通体重'],
            [24.9, '普通体重'],
            [25.0, '前肥満'],
            [27.0, '前肥満'],
            [29.9, '前肥満'],
            [30.0, '肥満(1度)'],
            [32.0, '肥満(1度)'],
            [34.9, '肥満(1度)'],
            [35.0, '肥満(2度)'],
            [37.0, '肥満(2度)'],
            [39.9, '肥満(2度)'],
            [40.0, '肥満(3度)'],
            [70.0, '肥満(3度)'],
            [99.9, '肥満(3度)'],
            [100.0, '-'],
            [200.0, '-'],
        ];
    }
}