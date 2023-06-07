<?php
namespace App\PizzaDelivery\Domain\CouponCondition;

use App\PizzaDelivery\Domain\Order\Order;

interface CouponConditionInterface {

    public function appliable(Order $order): bool;
    
}