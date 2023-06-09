<?php
namespace App\Beer\Domain\CouponSpecification;

use App\Beer\Domain\Discount;
use App\Beer\Domain\Money;
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
        $discounts = $order->getDiscounts();
        $discount = new Discount(
            null, 
            new Money($this->discountAmount), 
            'total price is discounted'
        );
        $discounts->add($discount);

        $appliedOrder = new Order(
            $order->getId(),
            $order->getPrice() - $this->discountAmount,
            $order->getCustomer(),
            $order->getOrderDetails(),
            $discounts,
            $order->getCoupons(),
            $order->getDeliveryFee(),
        );
        // var_dump('TotalPriceDiscountSpecification');
        // var_dump($appliedOrder->getPrice());

        return $appliedOrder;
    }
}