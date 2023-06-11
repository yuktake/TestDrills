<?php
namespace App\DeliveryFee\Domain;

class Money {

    private int $value;

    public function __construct(
        int $value,
    ) {
        if ($value < 0) {
            $value = 0;
        }

        $this->value = $value;
    }

    public function getValue(): int {
        return $this->value;
    }
}