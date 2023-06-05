<?php
namespace App\PrepaidCard\Domain\Customer\CustomerRank;

use App\PrepaidCard\Domain\Customer\CustomerRank\CustomerRankInterface;
use App\PrepaidCard\Enum\ChargeAmount;

class SilverRank implements CustomerRankInterface  {

    public function getBonusRatio(ChargeAmount $chargeAmount): float {
        switch($chargeAmount) {
            case ChargeAmount::SMALL:
                return 0.01;
            case ChargeAmount::MEDIUM:
                return 0.02;
            case ChargeAmount::LARGE:
                return 0.04;
            default:
                throw new \Exception('');
        }
    }
}