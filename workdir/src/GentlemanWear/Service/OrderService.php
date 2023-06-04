<?php
namespace App\GentlemanWear\Service;

use App\GentlemanWear\Domain\Order\Order;
use App\GentlemanWear\Domain\Order\OrderDomainService;

class OrderService {

    private $orderDomainService;

    public function __construct(
        OrderDomainService $orderDomainService,
    ) {
        $this->orderDomainService = $orderDomainService;
    }

    public function checkOrder(Order $order):Order {
        $order = $this->orderDomainService->applyDiscounts($order);

        return $order;
    }
}