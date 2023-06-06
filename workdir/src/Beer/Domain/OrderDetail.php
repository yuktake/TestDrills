<?php
namespace App\Beer\Domain;

class OrderDetail {

    private ?int $id;

    private String $uuid;

    private Money $price;

    private Discounts $discounts;

    private Product $product;

    public function __construct(
        ?int $id,
        int $price,
        Discounts $discounts,
        Product $product,
    ) {
        $this->id = $id;
        $this->uuid = uniqid();
        $this->price = new Money($price);
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

    public function getDiscounts():Discounts {
        return $this->discounts;
    }

    public function getProduct():Product {
        return $this->product;
    }
}