<?php
namespace App\TatamiConverter;

class TatamiConverter {

    private float $area;

    public function __construct(
        int $tatamiNum,
    ) {
        if ($tatamiNum < -128 || $tatamiNum > 127) {
            throw new \InvalidArgumentException();
        } else if ($tatamiNum <= 0) {
            throw new \Exception('畳数は１以上を入力してください。');
        } else {
            $this->area = 1.65 * $tatamiNum;
        }
    }

    public function getArea(): float {
        return $this->area;
    }
}