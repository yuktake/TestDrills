<?php
namespace App\KitchenScale;

class KitchenScale {
    
    private int $weight;

    private String $message;

    public function __construct(
        int $weight,
    ) {
        if ($weight < 0 || $weight > 2000 ) {
            $this->message = 'EEEE';
        } else {
            $this->message = strval($weight).'g';
        }
    }

    public function getWeight(): int {
        return $this->weight;
    }

    public function getMessage(): String {
        return $this->message;
    }
}