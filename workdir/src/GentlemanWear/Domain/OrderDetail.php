<?php
namespace App\GentlemanWear\Domain;

class OrderDetail {

    private ?int $id;

    private String $uuid;

    private Money $price;

    private Product $product;

    public function __construct(
        ?int $id,
        Money $price,
        Product $product,
    ) {
        $this->id = $id;
        $this->uuid = uniqid();
        $this->price = $price;
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
}