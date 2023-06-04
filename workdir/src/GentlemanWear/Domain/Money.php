<?php
namespace App\GentlemanWear\Domain;

class Money {
    
    private int $value;

    public function __construct(
        int $value,
    ) {
        if ($value < 0) {
            throw new \Exception('0円以上を設定してください');
        }

        $this->value = $value;
    }

    public function getValue():int {
        return $this->value;
    }
}