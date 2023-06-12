<?php
namespace App\AirConditioner\Domain;

enum RunningMode: int
{
    case COOLING = 1;
    case HEATING = 2;
    case DEHUMIDIFYING = 3;

    public static function fromValue(int $value): RunningMode {
        return match($value) {
            1 => self::COOLING, 
            2 => self::HEATING,
            3 => self::DEHUMIDIFYING,
        };
    }
}