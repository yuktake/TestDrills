<?php
namespace App\Beer\Domain;

class Money {

    private int $value;

    public function __construct(
        int $value,
    ) {
        if ($value < 0) {
            $this->value = 0;
        } else {
            $this->value = $value;
        }
    }

    public function getValue(): int {
        return $this->value;
    }
}