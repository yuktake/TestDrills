<?php
namespace App\HandiCraftsStore;

class ClothSalePrice {

    const NORMAL_UNIT_PRICE = 400;
    const LOT_UNIT_PRICE = 350;
    
    private float $clothMeterLength;

    private int $price;

    public function __construct(
        float $clothMeterLength,
    ) {
        if ($clothMeterLength < 0.1 || $clothMeterLength > 100.0) {
            throw new \InvalidArgumentException('-');
        }

        $roundingDownMeter = floor($clothMeterLength * 10) / 10;
        $this->clothMeterLength = $roundingDownMeter;

        if ($roundingDownMeter <= 3.0) {
            $this->price = $roundingDownMeter * self::NORMAL_UNIT_PRICE;
        } else {
            $this->price = $roundingDownMeter * self::LOT_UNIT_PRICE;
        }
    }

    public function getClothMeterLength(): float {
        return $this->clothMeterLength;
    }

    public function getPrice(): int {
        return $this->price;
    }
}