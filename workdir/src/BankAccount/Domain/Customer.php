<?php
namespace App\BankAccount\Domain;

class Customer {

    private ?int $id;

    private string $name;

    private bool $special;

    public function __construct(
        ?int $id,
        string $name,
        bool $special
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->special = $special;
    }

    public function getId():?int {
        return $this->id;
    }

    public function getName():string {
        return $this->name;
    }

    public function isSpecial():bool {
        return $this->special;
    }
}