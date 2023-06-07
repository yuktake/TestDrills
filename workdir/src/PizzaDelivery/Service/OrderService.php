<?php
namespace App\PizzaDelivery\Service;

use App\PizzaDelivery\Domain\Coupon\CouponInterface;
use App\PizzaDelivery\Domain\Order\Order;
use App\PizzaDelivery\Domain\Order\OrderDomainService;

class OrderService {

    private OrderDomainService $orderDomainService;

    public function __construct(
        OrderDomainService $orderDomainService,
    ) {
        $this->orderDomainService = $orderDomainService;
    }

    public function confirmOrder(Order $order):Order {
        $order = $this->orderDomainService->applyDiscount($order);

        return $order;
    }

    public function couponIsApplicable(Order $order, CouponInterface $coupon):bool {
        if (!$coupon->isAvailable()) {
            return false;
        }

        // Couponの使用回数が決まっている場合
        if (!is_null($coupon->getUseLimit())) {
            // TODO:: Repositoryから使用履歴を確認して判別する
        }

        // ユーザごとにCouponの使用回数が決まっている場合
        if (!is_null($coupon->getUseLimitByCustomer())) {
            // TODO:: Repositoryから顧客別使用履歴を確認して判別する
        }
    
        return $coupon->isApplicable($order);
    }

    public function applyCoupon(Order $order, CouponInterface $coupon): Order {
        $order->addCoupon($coupon);

        $appliedOrder = $this->orderDomainService->calculateCouponsOrder($order);

        return $appliedOrder;
    }

}