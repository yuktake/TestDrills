<?php
namespace App\PizzaDelivery\Domain\OrderDiscount;

use App\PizzaDelivery\Domain\Money;
use App\PizzaDelivery\Domain\Order\Order;
use App\PizzaDelivery\Enum\DeliveryType;

class PickupSecondPizzaFreeDiscount {

    public function isApplicable(Order $order):bool {
        return ($order->getDeliveryType() == DeliveryType::PICKUP) && ($order->countProductCategory('pizza') >= 2);
    }

    public function apply(Order $order):Order {
        // 既存のピザを無料にする
        $mostExpensivePizzaOrderDetailIndex = $order->getMostExpensiveOrderDetailIndex(categoryCode:'pizza');
        $order->beFreeOrderDetail($mostExpensivePizzaOrderDetailIndex);

        return new Order(
            $order->getId(),
            new Money($order->getPrice()),
            $order->getOrderDetails(),
            $order->getDiscounts(),
            $order->getCoupons(),
            $order->getDeliveryType(),
        );
    }
}