<?php
namespace App\Butcher;

class OrderDate {

    private \DateTimeImmutable $value;

    public function __construct(
        \DateTimeImmutable $orderAt,
    ) {
        $this->value = $orderAt;
    }

    public function isBargainDay():bool {
        $orderDay = $this->value->format('j');
        if ($orderDay <= 5 || ($orderDay >= 28 && $orderDay <= 30)) {
            return true;
        }

        return false;
    }
}