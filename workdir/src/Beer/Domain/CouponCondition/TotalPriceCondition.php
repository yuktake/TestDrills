<?php
namespace App\Beer\Domain\CouponCondition;

use App\Beer\Domain\Order;

class TotalPriceCondition implements CouponConditionInterface {

    private int $baseOrderTotalPrice;

    public function __construct(
        int $baseOrderTotalPrice,
    ) {
        $this->baseOrderTotalPrice = $baseOrderTotalPrice;
    }

    public function appliable(Order $order): bool
    {
        return $order->getPrice() >= $this->baseOrderTotalPrice;
    }
}