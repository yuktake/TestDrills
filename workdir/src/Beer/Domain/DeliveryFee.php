<?php
namespace App\Beer\Domain;

class DeliveryFee {

    private int $value;

    public function __construct(
        int $value
    ) {
        $this->value = $value;
    }

    public function getValue(): int {
        return $this->value;
    }
}