<?php
namespace App\BaggageSize\Enums;

enum BaggageWeightStandard: int
{
    case TWO_OR_LESS_KILOGRAMME = 1;
    case MORE_THAN_TWO_AND_FIVE_OR_LESS_KILOGRAMME = 2;
    case MORE_THAN_FIVE_AND_TEN_OR_LESS_KILOGRAMME = 3;

    public static function fromValue(int $value): BaggageWeightStandard {
        return match($value) {
            1 => self::TWO_OR_LESS_KILOGRAMME,
            2 => self::MORE_THAN_TWO_AND_FIVE_OR_LESS_KILOGRAMME,
            3 => self::MORE_THAN_FIVE_AND_TEN_OR_LESS_KILOGRAMME,
        };
    }
}