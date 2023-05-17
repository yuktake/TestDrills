<?php
namespace App\Beer\Domain;

class OrderDetails {

    private Array $orderDetails;

    public function __construct(
        Array $orderDetails,
    ) {
        $this->orderDetails = $orderDetails;
    }

    public function asArray():Array {
        return $this->orderDetails;
    }

    public function addOrderDetail(OrderDetail $orderDetail): OrderDetails {
        $this->orderDetails[] = $orderDetail;

        return new OrderDetails($this->orderDetails);
    }

    public function getTotalPrice(): Int {
        $totalPrice = 0;
        
        foreach($this->orderDetails as $orderDetail) {
            $totalPrice+=$orderDetail->getPrice();
        }

        return $totalPrice;
    }

    public function hasProduct(Product $product): bool {
        foreach($this->orderDetails as $orderDetail) {
            $orderDetailProduct = $orderDetail->getProduct();
            if ($orderDetailProduct->getName() == $product->getName()) {
                return true;
            }
        }

        return false;
    }
}