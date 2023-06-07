<?php
namespace App\PizzaDelivery\Domain\Product;

use App\PizzaDelivery\Domain\Money;

class Product {
    
    private ?int $id;

    private string $name;

    private Category $category;

    private Money $price;

    private String $productCode;


    public function __construct(
        ?int $id,
        string $name,
        Category $category,
        Money $price,
        string $productCode,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->category = $category;
        $this->price = $price;
        $this->productCode = $productCode;
    }

    public function getId():?int {
        return $this->id;
    }

    public function getName():string {
        return $this->name;
    }

    public function getCategory():Category {
        return $this->category;
    }

    public function getPrice():int {
        return $this->price->getValue();
    }

    public function getProductCode():string {
        return $this->productCode;
    }
}