<?php
namespace App\BankAccount\Service;

use App\BankAccount\Domain\Account;
use App\BankAccount\Domain\Money;
use App\BankAccount\Repository\HolidayRepository;

class AccountService {

    private $holidayRepository;

    public function __construct(
        HolidayRepository $holidayRepository,
    ) {
        $this->holidayRepository = $holidayRepository;
    }

    public function withdraw(Account $account, Money $withdrawAmount, \DateTimeImmutable $dateTime):Account {
        $isHoliday = $this->holidayRepository->isHoliday($dateTime);
        $account->withdraw($withdrawAmount, $dateTime, $isHoliday);

        return $account;
    }

}