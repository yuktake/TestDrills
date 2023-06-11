<?php
namespace App\DeliveryFee\Enum;

enum DeliveryType: int
{
    case NORMAL = 1;
    case EXPRESS = 2;

    public static function fromValue(int $value): DeliveryType {
        return match($value) {
            1 => self::NORMAL,
            2 => self::EXPRESS,
        };
    }
}