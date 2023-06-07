<?php
namespace App\PizzaDelivery\Domain\Coupon\CouponSpecification;

use App\PizzaDelivery\Domain\Order\Order;

interface CouponSpecificationInterface {

    public function apply(Order $order): Order;
    
}