<?php
namespace App\Bmi;

use App\Bmi\Enums\NutritionalStatus;

class BmiStatus {

    private NutritionalStatus $nutritionalStatus;

    public function __construct(
        float $value,
    ) {
        if ($value <= 0 || $value >= 100) {
            throw new \Exception('-');
        }
        
        $roundingDownBmi = floor($value * 10) / 10;

        if ($roundingDownBmi <= 0.0 || $roundingDownBmi >= 100.0) {
            throw new \Exception('-');
        } else if ($roundingDownBmi < 18.5) {
            $this->nutritionalStatus = NutritionalStatus::SKINNY;
        } else if ($roundingDownBmi <= 24.9) {
            $this->nutritionalStatus = NutritionalStatus::NORMAL;
        } else if ($roundingDownBmi <= 29.9) {
            $this->nutritionalStatus = NutritionalStatus::PRE_OBESITY;
        } else if ($roundingDownBmi <= 34.9) {
            $this->nutritionalStatus = NutritionalStatus::OBESITY_1;
        } else if ($roundingDownBmi <= 39.9) {
            $this->nutritionalStatus = NutritionalStatus::OBESITY_2;
        } else {
            $this->nutritionalStatus = NutritionalStatus::OBESITY_3;
        }
    }

    public function getValue():float {
        return $this->value;
    }

    public function getNutritionalStatus(): String {
        return $this->nutritionalStatus->value;
    }
}