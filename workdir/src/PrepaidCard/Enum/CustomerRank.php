<?php
namespace App\PrepaidCard\Enum;

enum CustomerRank: string
{
    case SILVER = 'SILVER';
    case GOLD = 'GOLD';
    case BLACK = 'BLACK';

    public static function fromValue(int $value): CustomerRank {
        return match($value) {
            'SILVER' => self::SILVER,
            'GOLD' => self::GOLD,
            'BLACK' => self::BLACK,
        };
    }
}