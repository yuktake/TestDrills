<?php
namespace App\BankAccount\Domain;

class Account {

    private ?int $id;

    private Customer $customer;

    private Money $balance;

    public function __construct(
        ?int $id,
        Customer $customer,
        Money $balance,
    ) {
        $this->id = $id;
        $this->customer = $customer;
        $this->balance = $balance;
    }

    public function getBalance():Money {
        return $this->balance;
    }

    public function withdraw(Money $money, \DateTimeImmutable $now, bool $isHoliday):void {
        $fee = 0;
        $day = $now->format('N');

        if($day == 6 || $day == 7 || $isHoliday) {
            $fee = 110;
        } else {
            $morningCostFeeStart = $now->modify('00:00:00');
            $morningCostFeeEnd = $now->modify('08:44:00');
            $eveningCostFeeStart = $now->modify('18:00:00');
            $eveningCostFeeEnd = $now->modify('23:59:00');

            if($now >= $morningCostFeeStart && $now <= $morningCostFeeEnd) {
                $fee = 110;
            } else if ($now >= $eveningCostFeeStart && $now <= $eveningCostFeeEnd) {
                $fee = 110;
            }
        }

        if ($this->customer->isSpecial()) {
            $fee = 0;
        }

        $value = $this->balance->getValue() - $money->getValue() - $fee;

        $this->balance = new Money($value);
    }
}