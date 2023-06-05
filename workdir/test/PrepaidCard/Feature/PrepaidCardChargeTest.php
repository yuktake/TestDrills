<?php

use App\PrepaidCard\Service\PrepaidCardService;
use App\PrepaidCard\Domain\Customer\Customer;
use App\PrepaidCard\Domain\Customer\CustomerRank\SilverRank;
use App\PrepaidCard\Domain\Money;
use App\PrepaidCard\Domain\PrepaidCard;
use App\PrepaidCard\Enum\ChargeAmount;
use App\PrepaidCard\Repository\CouponRepository;
use PHPUnit\Framework\TestCase;

class PrepaidCardChargeTest extends TestCase{

    protected function setUp() :void {
        
    }

    /**
     * @test
     * @dataProvider ５０００円以上チャージすると一定確率でクーポンが発行される用データ
     */
    public function ５０００円以上チャージすると一定確率でクーポンが発行される(
        ChargeAmount $chargeAmount,
        Customer $customer,
        int $probability,
        int $expectedBalance,
    ) {
        $couponRepository = new CouponRepository();
        $prepaidCardService = new PrepaidCardService($couponRepository);
        $prepaidCard = new PrepaidCard(1, $customer, new Money(0));
        $prepaidCard = $prepaidCardService->charge($prepaidCard, $chargeAmount, $probability);

        $this->assertEquals($expectedBalance, $prepaidCard->getAmount());
    }

    public static function ５０００円以上チャージすると一定確率でクーポンが発行される用データ() {
        $silverCustomer = new Customer(1,'silver', new SilverRank());

        return [
            '3000円チャージする' => [
                ChargeAmount::SMALL,
                $silverCustomer,
                1,
                3030,
            ],
            '5000円チャージしてクーポンが発行される' => [
                ChargeAmount::MEDIUM,
                $silverCustomer,
                10,
                5100,
            ],
            '10000円チャージしてクーポンが発行されない' => [
                ChargeAmount::LARGE,
                $silverCustomer,
                1,
                10400,
            ],
        ];
    }
}