<?php
namespace App\PrepaidCard\Domain;

use App\PrepaidCard\Domain\Customer\Customer;
use App\PrepaidCard\Enum\ChargeAmount;

class PrepaidCard {

    private ?int $id;

    private Customer $customer;

    private Money $amount;

    public function __construct(
        ?int $id,
        Customer $customer,
        Money $amount,
    ) {
        $this->id = $id;
        $this->customer = $customer;
        $this->amount = $amount;
    }

    public function getCustomer():Customer {
        return $this->customer;
    }

    public function getAmount():int {
        return $this->amount->getValue();
    }

    public function charge(ChargeAmount $chargeAmount) {
        $bonusRatio = $this->getBonusRatio($chargeAmount);
        $totalAmount = $this->amount->getValue() + $chargeAmount->value + ($chargeAmount->value * $bonusRatio);
        $this->amount = new Money($totalAmount);
    }

    private function getBonusRatio(ChargeAmount $chargeAmount):float {
        return $this->customer->getCustomerRank()->getBonusRatio($chargeAmount);
    }
}