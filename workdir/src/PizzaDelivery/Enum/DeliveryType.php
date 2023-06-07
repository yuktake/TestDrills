<?php
namespace App\PizzaDelivery\Enum;

enum DeliveryType: int
{
    case PICKUP = 1;
    case DELIVERY = 2;

    public static function fromValue(int $value): DeliveryType {
        return match($value) {
            1 => self::PICKUP,
            2 => self::DELIVERY,
        };
    }
}