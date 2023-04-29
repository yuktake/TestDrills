<?php
namespace App\Rpg\Enums;

enum HandedType: Int
{
    case SINGLE_HANDED = 1;
    case TWO_HANDED = 2;

    public static function fromValue(Int $value): HandedType {
        return match($value) {
            1 => self::SINGLE_HANDED,
            2 => self::TWO_HANDED,
        };
    }
}