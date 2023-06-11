<?php
namespace App\DeliveryFee\Domain\Order;

use App\DeliveryFee\Domain\Customer;
use App\DeliveryFee\Domain\Money;

class Order {
    
    private ?int $id;

    private Customer $customer;

    private Money $price;

    private DeliveryType $deliveryType;

    public function __construct(
        ?int $id,
        Customer $customer,
        Money $price,
        DeliveryType $deliveryType,
    ) {
        $this->id = $id;
        $this->customer = $customer;
        $this->price = $price;
        $this->deliveryType = $deliveryType;
    }

    public function getId():?int {
        return $this->id;
    }

    public function getPrice():int {
        return $this->price->getValue();
    }

    public function getDeliveryFee():int {
        if($this->getPrice() >= 5000) {
            return 0;
        }

        return $this->deliveryType->getFee($this->customer->isPremium());
    }
}