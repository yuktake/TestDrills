<?php
namespace App\DeliveryFee\Domain\Order;

use App\DeliveryFee\Enum\DeliveryType as DeliveryTypeEnum;

class DeliveryType {

    private DeliveryTypeEnum $value;

    public function __construct(
        DeliveryTypeEnum $value,
    ) {
        $this->value = $value;
    }

    public function getValue(): DeliveryTypeEnum {
        return $this->value;
    }

    public function getFee(bool $isPremium): int {
        $normalDeliveryFee = 500;
        $expressDeliveryFee = 0;

        if($this->value == DeliveryTypeEnum::EXPRESS) {
            $expressDeliveryFee = 500;
        }

        if($isPremium) {
            $normalDeliveryFee = 0;
        }

        return $normalDeliveryFee + $expressDeliveryFee;
    }
}