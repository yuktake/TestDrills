<?php
namespace App\Beer\Domain;

class Product {

    private String $name;

    private int $price;

    private String $productCode;

    private int $happyHourPrice;

    public function __construct(
        String $name,
        int $price,
        String $productCode,
        int $happyHourPrice,
    ) {
        $this->name = $name;
        $this->price = $price;
        $this->productCode = $productCode;
        $this->happyHourPrice = $happyHourPrice;
    }

    public function getName():String {
        return $this->name;
    }

    public function getPrice():int {
        return $this->price;
    }

    public function getProductCode():String {
        return $this->productCode;
    }

    public function getHappyHourPrice():int {
        return $this->happyHourPrice;
    }
}