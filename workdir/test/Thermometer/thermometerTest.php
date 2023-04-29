<?php

use App\Thermometer\Thermometer;
use PHPUnit\Framework\TestCase;

class thermometerTest extends TestCase{

    protected function setUp() :void {
        
    }

    /**
     * @test
     * @dataProvider 適切な気温を設定する用データ
     * @param $temperature
     */
    public function 適切な気温を設定する(
        float $temperature,
        String $expectedMessage,
    ) {
        $thermometer = new Thermometer($temperature);

        $this->assertEquals($expectedMessage, $thermometer->getMessage());
    }

    public static function 適切な気温を設定する用データ() {
        return [
            [23.0, '寒い'],
            [23.9, '寒い'],
            [23.999999999999, '寒い'],
            [24, '快適'],
            [25, '快適'],
            [25.9, '快適'],
            [26.0, '暑い'],
            [26.0000000000001, '暑い'],
            [26.1, '暑い'],
            [30, '暑い'],
        ];
    }
}