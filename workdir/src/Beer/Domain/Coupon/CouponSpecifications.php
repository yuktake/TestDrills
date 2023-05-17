<?php
namespace App\Beer\Domain\Coupon;

use App\Beer\Domain\Order;

class CouponSpecifications {

    private Array $couponSpecifications;

    public function __construct(
        Array $couponSpecifications,
    ) {
        $this->couponSpecifications = $couponSpecifications;
    }

    public function asArray():Array {
        return $this->couponSpecifications;
    }

    public function apply(Order $order): Order {
        foreach($this->couponSpecifications as $couponSpecification) {
            $order = $couponSpecification->apply($order);
        }

        return $order;
    }
}