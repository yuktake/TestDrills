<?php
namespace App\Beer\Domain;

class Discount {

    private ?int $id;

    private Money $price;

    private string $description;

    public function __construct(
        ?int $id,
        Money $price,
        string $description,
    ) {
        $this->id = $id;
        $this->price = $price;
        $this->description = $description;
    }

    public function getPrice():int {
        return $this->price->getValue();
    }

    public function getDescription():string {
        return $this->description;
    }
}