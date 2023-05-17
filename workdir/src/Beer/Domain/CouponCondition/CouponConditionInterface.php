<?php
namespace App\Beer\Domain\CouponCondition;

use App\Beer\Domain\Order;

interface CouponConditionInterface {

    public function appliable(Order $order): bool;
}