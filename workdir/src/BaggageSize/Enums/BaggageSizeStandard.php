<?php
namespace App\BaggageSize\Enums;

enum BaggageSizeStandard: int
{
    case SIXTY_SIZE = 1;
    case EIGHTY_SIZE = 2;
    case HUNDRED_SIZE = 3;

    public static function fromValue(int $value): BaggageSizeStandard {
        return match($value) {
            1 => self::SIXTY_SIZE,
            2 => self::EIGHTY_SIZE,
            3 => self::HUNDRED_SIZE,
        };
    }

    public static function output(int $value): String {
        return match($value) {
            1 => '60サイズ',
            2 => '80サイズ',
            3 => '100サイズ',
        };
    }
}