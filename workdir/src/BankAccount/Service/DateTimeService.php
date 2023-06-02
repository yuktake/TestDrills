<?php
namespace App\BankAccount\Service;

use App\BankAccount\Basic\DateTimeInterface;

class DateTimeService implements DateTimeInterface {

    public function getDateTimeForWithdraw(): \DateTimeImmutable {
        return new \DateTimeImmutable();
    }

}