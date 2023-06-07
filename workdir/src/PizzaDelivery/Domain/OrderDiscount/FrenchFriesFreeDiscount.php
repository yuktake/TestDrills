<?php
namespace App\PizzaDelivery\Domain\OrderDiscount;

use App\PizzaDelivery\Domain\Discounts\Discounts;
use App\PizzaDelivery\Domain\Money;
use App\PizzaDelivery\Domain\Order\Order;
use App\PizzaDelivery\Domain\Order\OrderDetail;
use App\PizzaDelivery\Domain\Product\Product;

class FrenchFriesFreeDiscount {

    public function isApplicable(Order $order):bool {
        return $order->getPrice() >= 1500;
    }

    public function apply(Order $order, Product $frenchFries):Order {
        $discountPrice = 0;

        if($order->hasProductCategory('french-fries')) {
            // 既存のポテトを無料にする
            $mostExpensiveFrenchFriesOrderDetailIndex = $order->getOrderDetails()->getMostExpensiveOrderDetailIndex('french-fries');
            $order->beFreeOrderDetail($mostExpensiveFrenchFriesOrderDetailIndex);
            $discountPrice = $frenchFries->getPrice();
        } else {
            $frenchFriesOrderDetail = new OrderDetail(
                null, 
                new Money($frenchFries->getPrice()),
                new Discounts([]),
                $frenchFries
            );
            $frenchFriesOrderDetail->beFree();
            $order->addOrderDetail($frenchFriesOrderDetail);
        }

        return new Order(
            $order->getId(),
            new Money($order->getPrice() - $discountPrice),
            $order->getOrderDetails(),
            $order->getDiscounts(),
            $order->getCoupons(),
            $order->getDeliveryType(),
        );
    }
}