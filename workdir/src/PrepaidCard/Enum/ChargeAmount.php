<?php
namespace App\PrepaidCard\Enum;

enum ChargeAmount: int
{
    case SMALL = 3000;
    case MEDIUM = 5000;
    case LARGE = 10000;

    public static function fromValue(int $value): ChargeAmount {
        return match($value) {
            3000 => self::SMALL,
            5000 => self::MEDIUM,
            10000 => self::LARGE,
        };
    }
}