<?php

use App\BankAccount\Domain\Account;
use App\BankAccount\Domain\Customer;
use App\BankAccount\Domain\Money;
use App\BankAccount\Repository\HolidayRepository;
use App\BankAccount\Service\AccountService;
use PHPUnit\Framework\TestCase;

class BankAccountTest extends TestCase{

    protected function setUp() :void {
        
    }

    /**
     * @test
     * @dataProvider 平日は時刻に応じて手数料が変動する用データ
     */
    public function 平日は時刻に応じて手数料が変動する(
        \DateTimeImmutable $withdrawDateTime,
        int $expectedPrice,
    ) {
        $holidayRepository = new HolidayRepository();
        $accountServie = new AccountService($holidayRepository);
        $customer = new Customer(1,'Bob',false);
        $account = new Account(1,$customer,new Money(1000000));
        $account = $accountServie->withdraw($account, new Money(100000), $withdrawDateTime);

        $this->assertEquals($expectedPrice, $account->getBalance()->getValue());
    }

    /**
     * @test
     * @dataProvider 土日祝日は手数料がかかる用データ
     */
    public function 土日祝日は手数料がかかる(
        \DateTimeImmutable $withdrawDateTime,
        int $expectedPrice,
    ) {
        $holidayRepository = new HolidayRepository();
        $accountServie = new AccountService($holidayRepository);
        $customer = new Customer(1,'Bob',false);
        $account = new Account(1,$customer,new Money(1000000));
        $account = $accountServie->withdraw($account, new Money(100000), $withdrawDateTime);

        $this->assertEquals($expectedPrice, $account->getBalance()->getValue());
    }

    /**
     * @test
     * @dataProvider 特別会員は手数料がかからない用データ
     */
    public function 特別会員は手数料がかからない(
        Customer $customer,
        \DateTimeImmutable $withdrawDateTime,
        int $expectedPrice,
    ) {
        $holidayRepository = new HolidayRepository();
        $accountServie = new AccountService($holidayRepository);
        $account = new Account(1,$customer,new Money(1000000));
        $account = $accountServie->withdraw($account, new Money(100000), $withdrawDateTime);

        $this->assertEquals($expectedPrice, $account->getBalance()->getValue());
    }

    public static function 平日は時刻に応じて手数料が変動する用データ() {
        return [
            '00:00から08:44' => [
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2023-05-01 00:00:00'),
                899890,
            ],
            '08:45から17:59' => [
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2023-05-01 08:45:00'),
                900000,
            ],
            '18:00から23:59' => [
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2023-05-01 18:00:00'),
                899890,
            ],
        ];
    }

    public static function 土日祝日は手数料がかかる用データ() {
        return [
            '土曜日' => [
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2023-05-06 00:00:00'),
                899890,
            ],
            '日曜日' => [
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2023-05-07 08:45:00'),
                899890,
            ],
            '祝日' => [
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2023-05-05 18:00:00'),
                899890,
            ],
        ];
    }

    public static function 特別会員は手数料がかからない用データ() {
        $normalCustomer = new Customer(1, 'Bob', false);
        $specialCustomer = new Customer(1, 'Bob', true);

        return [
            '特別会員である' => [
                $specialCustomer,
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2023-05-06 00:00:00'),
                900000,
            ],
            '特別会員でない' => [
                $normalCustomer,
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2023-05-07 08:45:00'),
                899890,
            ],
        ];
    }
}