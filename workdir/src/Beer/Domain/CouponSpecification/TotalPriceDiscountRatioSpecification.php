<?php
namespace App\Beer\Domain\CouponSpecification;

use App\Beer\Domain\Discount;
use App\Beer\Domain\Money;
use App\Beer\Domain\Order;

class TotalPriceDiscountRatioSpecification implements CouponSpecificationInterface {

    private float $discountRatio;

    public function __construct(
        float $discountRatio,
    ) {
        if($discountRatio <= 0.0 || $discountRatio >= 1.0) {
            throw new \Exception('does not discount');
        }
        $this->discountRatio = $discountRatio;
    }

    public function apply(Order $order): Order
    {
        $discounts = $order->getDiscounts();
        $discount = new Discount(
            null, 
            new Money($order->getPrice() * $this->discountRatio), 
            'total price is discounted by ratio'
        );
        $discounts->add($discount);

        $appliedOrder = new Order(
            $order->getId(),
            $order->getPrice() - ($order->getPrice() * $this->discountRatio) ,
            $order->getCustomer(),
            $order->getOrderDetails(),
            $discounts,
            $order->getCoupons(),
            $order->getDeliveryFee(),
        );
        // var_dump('TotalPriceDiscountRatioSpecification');
        // var_dump($appliedOrder->getPrice());

        return $appliedOrder;
    }
}