<?php
namespace App\PrepaidCard\Domain\Customer;

use App\PrepaidCard\Domain\Customer\CustomerRank\CustomerRankInterface;

class Customer {

    private ?int $id;

    private string $name;

    private CustomerRankInterface $customerRank;

    public function __construct(
        ?int $id,
        string $name,
        CustomerRankInterface $customerRank,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->customerRank = $customerRank;
    }

    public function getCustomerRank():CustomerRankInterface {
        return $this->customerRank;
    }
}