<?php

use App\KitchenScale\KitchenScale;
use PHPUnit\Framework\TestCase;

class kitchenScaleTest extends TestCase{

    protected function setUp() :void {
        
    }

    /**
     * @test
     * @dataProvider 適切な重さを設定する用データ
     * @param $weight
     */
    public function 適切な重さを設定する(
        float $weight,
        String $expectedMessage,
    ) {
        $kitchenScale = new KitchenScale($weight);

        $this->assertEquals($expectedMessage, $kitchenScale->getMessage());
    }

    public static function 適切な重さを設定する用データ() {
        return [
            [-1000, 'EEEE'],
            [-1, 'EEEE'],
            [0, '0g'],
            [1000, '1000g'],
            [2000, '2000g'],
            [2001, 'EEEE'],
            [2500, 'EEEE'],
        ];
    }
}