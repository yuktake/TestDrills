<?php
namespace App\PrepaidCard\Domain\Customer\CustomerRank;

use App\PrepaidCard\Domain\Customer\CustomerRank\CustomerRankInterface;
use App\PrepaidCard\Enum\ChargeAmount;

class GoldRank implements CustomerRankInterface  {

    public function getBonusRatio(ChargeAmount $chargeAmount): float {
        switch($chargeAmount) {
            case ChargeAmount::SMALL:
                return 0.03;
            case ChargeAmount::MEDIUM:
                return 0.05;
            case ChargeAmount::LARGE:
                return 0.1;
            default:
                throw new \Exception('');
        }
    }
}