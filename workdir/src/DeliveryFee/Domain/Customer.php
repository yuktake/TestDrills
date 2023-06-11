<?php
namespace App\DeliveryFee\Domain;

class Customer {

    private ?int $id;

    private String $name;

    private bool $isPremium;

    public function __construct(
        ?int $id,
        String $name,
        bool $isPremium,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->isPremium = $isPremium;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getName(): String {
        return $this->name;
    }

    public function isPremium(): bool {
        return $this->isPremium;
    }
}