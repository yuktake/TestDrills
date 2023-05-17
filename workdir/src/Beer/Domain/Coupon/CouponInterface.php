<?php
namespace App\Beer\Domain\Coupon;

use App\Beer\Enums\CouponTarget;
use App\Beer\Enums\DiscountType;
use App\Beer\Domain\Order;

interface CouponInterface {

    public function isApplicable(Order $order): bool;

    public function apply(Order $order):Order;

    public function getCouponTarget():CouponTarget;

    public function getDiscountType():DiscountType;

    public function getUseLimit():?int;

    public function getUseLimitByCustomer():?int;

    public function isAvailable():bool;
    
}