<?php
namespace App\GentlemanWear\Domain\Order;

use App\GentlemanWear\Domain\Money;
use App\GentlemanWear\Domain\OrderDetails;

class Order {
    
    private ?int $id;

    private Money $price;

    private OrderDetails $orderDetails;

    private \DateTimeImmutable $orderAt;

    public function __construct(
        ?int $id,
        Money $price,
        OrderDetails $orderDetails,
        \DateTimeImmutable $orderAt,
    ) {
        $this->id = $id;
        $this->price = $price;
        $this->orderDetails = $orderDetails;
        $this->orderAt = $orderAt;
    }

    public function getId():?int {
        return $this->id;
    }

    public function getPrice():int {
        return $this->price->getValue();
    }

    public function getOrderDetails():OrderDetails {
        return $this->orderDetails;
    }

    public function getOrderAt():\DateTimeImmutable {
        return $this->orderAt;
    }
}