<?php
namespace App\Butcher;

use App\Butcher\Interface\DiscountInterface;

class DateDiscount implements DiscountInterface {

    private int $value;

    public function __construct(
        int $totalPrice,
    ) {
        $discountPrice = $totalPrice * 0.2;
        $this->value = floor($discountPrice);
    }

    public function getValue(): int
    {
        return $this->value;
    }
}