<?php

use App\HandiCraftsStore\ClothSalePrice;
use PHPUnit\Framework\TestCase;

class clothSalePriceTest extends TestCase{

    protected function setUp() :void {
        
    }

    /**
     * @test
     * @dataProvider 適切な長さを設定する用データ
     */
    public function 適切な長さを設定する(
        float $length,
        $expectedValue,
    ) {
        $price = null;
        try {
            $clothSalePrice = new ClothSalePrice($length);
            $price = $clothSalePrice->getPrice();
        } catch(\InvalidArgumentException $e) {
            $price = $e->getMessage();
        }

        $this->assertEquals($expectedValue, $price);
    }

    public static function 適切な長さを設定する用データ() {
        return [
            [0.0, '-'],
            [0.1, 40],
            [1.0, 400],
            [3.0, 1200],
            [3.1, 1085],
            [50.0, 17500],
            [100.0, 35000],
            [100.1, '-'],
            [200.0, '-'],
        ];
    }
}