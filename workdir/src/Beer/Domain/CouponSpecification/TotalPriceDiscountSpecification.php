<?php
namespace App\Beer\Domain\CouponSpecification;

use App\Beer\Domain\Order;

class TotalPriceDiscountSpecification implements CouponSpecificationInterface {

    private int $discountAmount;

    public function __construct(
        int $discountAmount,
    ) {
        $this->discountAmount = $discountAmount;
    }

    public function apply(Order $order): Order
    {
        $appliedOrder = new Order(
            $order->getId(),
            $order->getPrice() - $this->discountAmount,
            $order->getCustomer(),
            $order->getOrderDetails(),
            $order->getCoupons(),
            $order->getDeliveryFee(),
        );

        return $appliedOrder;
    }
}