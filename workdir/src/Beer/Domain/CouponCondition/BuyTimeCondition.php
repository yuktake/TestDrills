<?php
namespace App\Beer\Domain\CouponCondition;

use App\Beer\Domain\Order;

class BuyTimeCondition implements CouponConditionInterface {

    private int $baseBuyTime;

    private int $buyTime;

    public function __construct(
        int $baseBuyTime,
        int $buyTime,
    ) {
        $this->baseBuyTime = $baseBuyTime;
        $this->buyTime = $buyTime;
    }

    public function appliable(Order $order): bool
    {
        return $this->buyTime >= $this->baseBuyTime;
    }
}