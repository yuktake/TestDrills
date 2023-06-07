<?php
namespace App\PizzaDelivery\Domain\Order;

use App\PizzaDelivery\Domain\Coupon\CouponInterface;

class Coupons {

    private Array $coupons;

    public function __construct(
        Array $coupons,
    ) {
        $this->coupons = $coupons;
    }

    public function asArray():Array {
        return $this->coupons;
    }

    public function addCoupon(CouponInterface $coupon):self {
        $this->coupons[] = $coupon;

        return new Coupons($this->coupons);
    }

    public function hasCoupon(CouponInterface $targetCoupon):bool {
        foreach($this->coupons as $coupon) {
            if ($coupon->getCode() == $targetCoupon->getCode()) {
                return true;
            }
        }

        return false;
    }

    public function apply(Order $order): Order {
        foreach($this->coupons as $coupon) {
            $order = $coupon->apply($order);
        }

        return $order;
    }
}