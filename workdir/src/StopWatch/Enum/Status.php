<?php
namespace App\StopWatch\Enum;

enum Status: int
{
    case PREPARE = 1;
    case MEASURE = 2;
    case PAUSE = 3;

    public static function fromValue(int $value): Status {
        return match($value) {
            1 => self::PREPARE, 
            2 => self::MEASURE,
            3 => self::PAUSE,
        };
    }
}