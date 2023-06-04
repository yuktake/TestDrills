<?php
namespace App\GentlemanWear\Domain;



class Product {

    private ?int $id;

    private string $name;

    private Category $category;

    private Money $price;

    public function __construct(
        ?int $id,
        string $name,
        Category $category,
        Money $price,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->category = $category;
        $this->price = $price;
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
}