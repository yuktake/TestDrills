<?php
namespace App\PizzaDelivery\Domain\Coupon\CouponSpecification;

use App\PizzaDelivery\Domain\Coupon\CouponSpecification\CouponSpecificationInterface;
use App\PizzaDelivery\Domain\Discounts\Discount;
use App\PizzaDelivery\Domain\Money;
use App\PizzaDelivery\Domain\Order\Order;

class DiscountOrderPriceByRatioSpecification implements CouponSpecificationInterface {

    private float $ratio;

    public function __construct(
        float $ratio,
    ) {
        if($ratio <= 0.0 || 1.0 <= $ratio) {
            throw new \Exception('Does not be discounted');
        }
        $this->ratio = $ratio;
    }

    public function apply(Order $order): Order {
        $discounts = $order->getDiscounts();
        $discountedPrice = $order->getPrice() * $this->ratio;
        $discount = new Discount(
            null, 
            new Money($discountedPrice), 
            'Order is discounted'
        );
        $discounts->add($discount);

        return new Order(
            $order->getId(),
            new Money($order->getPrice() - $discountedPrice),
            $order->getOrderDetails(),
            $order->getDiscounts(),
            $order->getCoupons(),
            $order->getDeliveryType(),
        );
    }
}