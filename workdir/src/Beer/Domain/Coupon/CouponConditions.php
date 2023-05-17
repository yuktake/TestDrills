<?php
namespace App\Beer\Domain\Coupon;

use App\Beer\Domain\Order;

class CouponConditions {

    private Array $couponConditions;

    public function __construct(
        Array $couponConditions,
    ) {
        $this->couponConditions = $couponConditions;
    }

    public function asArray():Array {
        return $this->couponConditions;
    }

    public function appliable(Order $order): bool {
        foreach($this->couponConditions as $couponCondition) {
            if (!$couponCondition->appliable($order)) {
                return false;
            }
        }

        return true;
    }
}