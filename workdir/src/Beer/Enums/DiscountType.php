<?php
namespace App\Beer\Enums;

enum DiscountType: int
{
    case RATIO = 1;
    case SPECIFIC_PRICE = 2;
    case FREE = 3;

    public static function fromValue(int $value): DiscountType {
        return match($value) {
            1 => self::RATIO,
            2 => self::SPECIFIC_PRICE,
            3 => self::FREE,
        };
    }
}