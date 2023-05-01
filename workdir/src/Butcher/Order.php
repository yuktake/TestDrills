<?php
namespace App\Butcher;

use App\Butcher\Interface\DiscountInterface;

class Order {

    private int $totalPrice;

    private DiscountCollection $discounts;

    private OrderDate $orderAt;

    public function __construct(
        int $totalPrice,
        OrderDate $orderAt,
    ) {
        $this->totalPrice = $totalPrice;
        $this->discounts = new DiscountCollection([]);
        $this->orderAt = $orderAt;
        
        if ($orderAt->isBargainDay()) {
            $dateDiscount = new DateDiscount($totalPrice);
            $this->addDiscount($dateDiscount);
        }
    }

    public function addDiscount(DiscountInterface $discount):void {
        $this->discounts->addDiscount($discount);
    }

    public function sumDiscount():int {
        return $this->discounts->sumDiscountValue();
    }

    public function getTotalPrice():int {
        return $this->totalPrice - $this->sumDiscount();
    }
}