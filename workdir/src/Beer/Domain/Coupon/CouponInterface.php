<?php
namespace App\Beer\Domain\Coupon;

use App\Beer\Domain\Order;

interface CouponInterface {

    public function isApplicable(Order $order): bool;

    public function apply(Order $order):Order;

    public function getUseLimit():?int;

    public function getUseLimitByCustomer():?int;

    public function isAvailable():bool;
    
}