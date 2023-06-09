<?php
namespace App\GentlemanWear\Domain;

class Category {
    
    private ?int $id;

    private string $code;

    private string $name;

    public function __construct(
        ?int $id,
        string $code,
        string $name,
    ) {
        $this->id = $id;
        $this->code = $code;
        $this->name = $name;
    }

    public function getId():?int {
        return $this->id;
    }

    public function getCode():string {
        return $this->code;
    }

    public function getName():string {
        return $this->name;
    }
}