<?php
namespace App\AdmissionFee;

class AdmissionFee {

    private String $fee;

    public function __construct(
        int $age,
    ) {
        if ($age < 0) {
            throw new \InvalidArgumentException('-');
        } else if($age < 6) {
            $this->fee = 0;
        } else if($age < 13) {
            $this->fee = 500;
        } else if($age < 18) {
            $this->fee = 1000;
        } else {
            $this->fee = 1500;
        }
    }

    public function getFee(): int {
        return $this->fee;
    }
}