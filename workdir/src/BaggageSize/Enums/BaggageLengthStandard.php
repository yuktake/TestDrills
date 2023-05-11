<?php
namespace App\BaggageSize\Enums;

enum BaggageLengthStandard: int
{
    case SIXTY_OR_LESS_CENTIMETER = 1;
    case SIXTY_ONE_OR_MORE_AND_EIGHTY_OR_LESS_CENTIMETER = 2;
    case EIGHTY_ONE_OR_MORE_AND_HUNDRED_OR_LESS_CENTIMETER = 3;

    public static function fromValue(int $value): BaggageLengthStandard {
        return match($value) {
            1 => self::SIXTY_OR_LESS_CENTIMETER,
            2 => self::SIXTY_ONE_OR_MORE_AND_EIGHTY_OR_LESS_CENTIMETER,
            3 => self::EIGHTY_ONE_OR_MORE_AND_HUNDRED_OR_LESS_CENTIMETER,
        };
    }
}