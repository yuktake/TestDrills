<?php
namespace App\PizzaDelivery\Domain\Order;

use App\PizzaDelivery\Domain\Discounts\Discount;
use App\PizzaDelivery\Domain\Discounts\Discounts;
use App\PizzaDelivery\Domain\Money;
use App\PizzaDelivery\Domain\Product\Product;

class OrderDetail {

    private ?int $id;

    private String $uuid;

    private Money $price;

    private Discounts $discounts;

    private Product $product;

    public function __construct(
        ?int $id,
        Money $price,
        Discounts $discounts,
        Product $product,
    ) {
        $this->id = $id;
        $this->uuid = uniqid();
        $this->price = $price;
        $this->discounts = $discounts;
        $this->product = $product;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getUuid(): String {
        return $this->uuid;
    }

    public function getPrice(): int {
        return $this->price->getValue();
    }

    public function getProduct():Product {
        return $this->product;
    }

    public function getDiscounts():Discounts {
        return $this->discounts;
    }

    public function beFree():void {
        $discountedPrice = new Money($this->getPrice());
        $this->discounts->add(
            new Discount(null, $discountedPrice, $this->product->getName().' is free'),
        );
        $this->price = new Money(0);
    }
}