<?php
namespace App\Beer\Domain;

class Customer {

    private String $name;

    private \DateTimeImmutable $birthDay;

    public function __construct(
        String $name,
        \DateTimeImmutable $birthDay,
    ) {
        $this->name = $name;
        $this->birthDay = $birthDay;
    }

    public function getName(): String {
        return $this->name;
    }

    public function getBirthday(): \DateTimeImmutable {
        return $this->birthDay;
    }
}