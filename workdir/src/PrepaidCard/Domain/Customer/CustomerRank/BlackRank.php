<?php
namespace App\PrepaidCard\Domain\Customer\CustomerRank;

use App\PrepaidCard\Domain\Customer\CustomerRank\CustomerRankInterface;
use App\PrepaidCard\Enum\ChargeAmount;

class BlackRank implements CustomerRankInterface  {

    public function getBonusRatio(ChargeAmount $chargeAmount): float {
        switch($chargeAmount) {
            case ChargeAmount::SMALL:
                return 0.05;
            case ChargeAmount::MEDIUM:
                return 0.07;
            case ChargeAmount::LARGE:
                return 0.15;
            default:
                throw new \Exception('');
        }
    }
}