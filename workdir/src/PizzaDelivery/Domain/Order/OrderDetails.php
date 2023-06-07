<?php
namespace App\PizzaDelivery\Domain\Order;

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

    public function getTotalPrice(): Int {
        $totalPrice = 0;
        
        foreach($this->orderDetails as $orderDetail) {
            $totalPrice+=$orderDetail->getPrice();
        }

        return $totalPrice;
    }

    public function beFree(int $index):void {
        $this->orderDetails[$index]->beFree();
    }
}