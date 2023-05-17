<?php
namespace App\Beer\Domain\CouponSpecification;

use App\Beer\Domain\Order;
use App\Beer\Domain\OrderDetail;
use App\Beer\Domain\OrderDetails;

class SpecificProductDiscountSpecification implements CouponSpecificationInterface {

    private String $productCode;

    private int $appliedPrice;

    public function __construct(
        String $productCode,
        int $appliedPrice,
    ) {
        $this->productCode = $productCode;
        $this->appliedPrice = $appliedPrice;
    }

    public function apply(Order $order): Order
    {
        $appliedOrderDetails = [];
        foreach($order->getOrderDetails()->asArray() as $orderDetail) {
            $product = $orderDetail->getProduct();
            if ($orderDetail->getProduct()->getProductCode() == $this->productCode) {
                $appliedOrderDetail = new OrderDetail(
                    $orderDetail->getId(),
                    $this->appliedPrice,
                    $product,
                );
                $appliedOrderDetails[] = $appliedOrderDetail;
            } else {
                $appliedOrderDetails[] = $orderDetail;
            }
        }
        $orderDetails = new OrderDetails($appliedOrderDetails);

        $appliedOrder = new Order(
            $order->getId(),
            $orderDetails->getTotalPrice(),
            $order->getCustomer(),
            $orderDetails,
            $order->getCoupons(),
            $order->getDeliveryFee(),
        );

        return $appliedOrder;
    }
}