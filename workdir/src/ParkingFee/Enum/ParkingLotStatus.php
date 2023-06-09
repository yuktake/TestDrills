<?php
namespace App\ParkingFee\Enum;

enum ParkingLotStatus: int
{
    case PARKING = 1;
    case PAID = 2;

    public static function fromValue(int $value): ParkingLotStatus {
        return match($value) {
            1 => self::PARKING, 
            2 => self::PAID,
        };
    }
}