<?php

use App\AirConditioner\Domain\AirConditioner;
use App\AirConditioner\Domain\RunningMode;
use PHPUnit\Framework\TestCase;

class AirConditionerTest extends TestCase{

    protected function setUp() :void {
        
    }

    /**
     * @test
     */
    public function 初回運転は冷房モードで起動する() {
        $airConditioner = new AirConditioner();

        $this->assertEquals(RunningMode::COOLING, $airConditioner->getMode());
    }

    /**
     * @test
     * @dataProvider 運転切替ボタンテスト用データ
     */
    public function 運転切替ボタンテスト(
        AirConditioner $airConditioner,
        RunningMode $expectedMode,
    ) {
        $airConditioner->run();
        $airConditioner->changeMode();

        $this->assertEquals($expectedMode, $airConditioner->getMode());
    }

    public static function 運転切替ボタンテスト用データ() {
        return [
            '冷房から暖房' => [
                new AirConditioner(RunningMode::COOLING),
                RunningMode::HEATING,
            ],
            '暖房から除湿' => [
                new AirConditioner(RunningMode::HEATING),
                RunningMode::DEHUMIDIFYING,
            ],
            '除湿から冷房' => [
                new AirConditioner(RunningMode::DEHUMIDIFYING),
                RunningMode::COOLING,
            ],
        ];
    }
}