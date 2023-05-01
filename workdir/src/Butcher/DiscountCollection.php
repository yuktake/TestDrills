<?php
namespace App\Butcher;

use App\Butcher\Interface\DiscountInterface;

class DiscountCollection {

    private Array $discounts;

    public function __construct(
        Array $discounts,
    ) {
        $this->discounts = $discounts;
    }

    public function addDiscount(DiscountInterface $discount) {
        switch (get_class($discount)) {
            case 'App\Butcher\DateDiscount':
                $this->addDateDiscount($discount);
                break;
            default:
                new \Exception('存在しない割引です');
        }
    }

    private function addDateDiscount(DateDiscount $discount):void {
        if($this->checkDateDiscountExist()) {
            throw new \Exception('特売日割引はすでに適応済みです');
        }
        $this->discounts[] = $discount;
    }

    public function checkDateDiscountExist():bool {
        foreach($this->discounts as $item) {
            if(is_a($item, 'App\Butcher\DateDiscount')) {
                return true;
            }
        }

        return false;
    }

    public function sumDiscountValue(): int {
        $sumDiscount = 0;
        foreach($this->discounts as $discount) {
            $sumDiscount += $discount->getValue();
        }

        return $sumDiscount;
    }
}