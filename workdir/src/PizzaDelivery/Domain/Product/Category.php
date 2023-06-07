<?php
namespace App\PizzaDelivery\Domain\Product;

class Category {
    
    private ?int $id;

    private string $name;

    private string $code;

    public function __construct(
        ?int $id,
        string $name,
        string $code,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->code = $code;
    }

    public function getId():?int {
        return $this->id;
    }

    public function getCode():string {
        return $this->code;
    }
}