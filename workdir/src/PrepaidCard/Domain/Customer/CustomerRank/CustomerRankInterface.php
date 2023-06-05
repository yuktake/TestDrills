<?php
namespace App\PrepaidCard\Domain\Customer\CustomerRank;

use App\PrepaidCard\Enum\ChargeAmount;

interface CustomerRankInterface {

    public function getBonusRatio(ChargeAmount $chargeAmount):float;
}