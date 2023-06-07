<?php
namespace App\PizzaDelivery\Domain\Coupon;

use App\PizzaDelivery\Domain\Order\Order;

interface CouponInterface {

    public function isApplicable(Order $order): bool;

    public function apply(Order $order):Order;

    public function getUseLimit():?int;

    public function getUseLimitByCustomer():?int;

    public function isAvailable():bool;
    
}