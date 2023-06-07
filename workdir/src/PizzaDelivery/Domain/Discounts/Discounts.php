<?php
namespace App\PizzaDelivery\Domain\Discounts;

class Discounts {

    private Array $discounts;

    public function __construct(
        Array $discounts,
    ) {
        $this->discounts = $discounts;
    }

    public function asArray():Array {
        return $this->discounts;
    }

    public function add(Discount $discount):void {
        $this->discounts[] = $discount;
    }
}