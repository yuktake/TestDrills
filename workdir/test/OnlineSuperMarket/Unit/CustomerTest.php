<?php

use App\OnlineSupermarket\Domain\Customer\CardMembershipInfo;
use App\OnlineSupermarket\Domain\Customer\Customer;
use App\OnlineSupermarket\Domain\Customer\MobileMembershipInfo;
use App\OnlineSupermarket\Domain\Customer\SpecialMembershipInfo;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase{

    protected function setUp() :void {
        
    }

    /**
     * @test
     * @dataProvider 特別会員はポイント３倍用データ
     */
    public function 特別会員はポイント３倍(
        Customer $customer,
        \DateTimeImmutable $today,
        int $expectedTimes,
    ) {
        $this->assertEquals($expectedTimes, $customer->getTimesForPoint($today));
    }

    /**
     * @test
     * @dataProvider カード会員はポイント２倍用データ
     */
    public function カード会員はポイント２倍(
        Customer $customer,
        \DateTimeImmutable $today,
        int $expectedTimes,
    ) {
        $this->assertEquals($expectedTimes, $customer->getTimesForPoint($today));
    }
    
    /**
     * @test
     * @dataProvider モバイル会員はポイント５倍用データ
     */
    public function モバイル会員はポイント５倍(
        Customer $customer,
        \DateTimeImmutable $today,
        int $expectedTimes,
    ) {
        $this->assertEquals($expectedTimes, $customer->getTimesForPoint($today));
    }

    /**
     * @test
     * @dataProvider 毎月15日はポイント3倍用データ
     */
    public function 毎月15日はポイント3倍(
        Customer $customer,
        \DateTimeImmutable $today,
        int $expectedTimes,
    ) {
        $this->assertEquals($expectedTimes, $customer->getTimesForPoint($today));
    }

    public static function 特別会員はポイント３倍用データ() {
        $specialMembershipInfo = new SpecialMembershipInfo();

        return [
            '特別会員である' => [
                new Customer(1, 'bob', $specialMembershipInfo, null, null),
                \DateTimeImmutable::createFromFormat('Y-m-d', '2023-01-01'),
                3,
            ],
            '特別会員でない' => [
                new Customer(1, 'bob', null, null, null),
                \DateTimeImmutable::createFromFormat('Y-m-d', '2023-01-01'),
                1,
            ],
        ];
    }

    public static function カード会員はポイント２倍用データ() {
        $cardMembershipInfo = new CardMembershipInfo();

        return [
            'カード会員である' => [
                new Customer(1, 'bob', null, $cardMembershipInfo, null),
                \DateTimeImmutable::createFromFormat('Y-m-d', '2023-01-01'),
                2,
            ],
            'カード会員でない' => [
                new Customer(1, 'bob', null, null, null),
                \DateTimeImmutable::createFromFormat('Y-m-d', '2023-01-01'),
                1,
            ],
        ];
    }

    public static function モバイル会員はポイント５倍用データ() {
        $mobileMembershipInfo = new MobileMembershipInfo();

        return [
            'モバイル会員である' => [
                new Customer(1, 'bob', null, null, $mobileMembershipInfo),
                \DateTimeImmutable::createFromFormat('Y-m-d', '2023-01-01'),
                5,
            ],
            'モバイル会員でない' => [
                new Customer(1, 'bob', null, null, null),
                \DateTimeImmutable::createFromFormat('Y-m-d', '2023-01-01'),
                1,
            ],
        ];
    }

    public static function 毎月15日はポイント3倍用データ() {
        return [
            '15日である' => [
                new Customer(1, 'bob', null, null, null),
                \DateTimeImmutable::createFromFormat('Y-m-d', '2023-01-15'),
                3,
            ],
            '15日でない' => [
                new Customer(1, 'bob', null, null, null),
                \DateTimeImmutable::createFromFormat('Y-m-d', '2023-01-01'),
                1,
            ],
        ];
    }
}