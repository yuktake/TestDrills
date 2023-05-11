<?php
namespace App\DepartmentCode;

class DepartmentCode {

    private int $value;

    public function __construct(
        int $value,
    ) {
        if ($value <= 99 || $value >= 1000) {
            throw new \Exception('Error');
        }

        $this->value = $value;
    }

    public function getValue():int {
        return $this->value;
    }
}