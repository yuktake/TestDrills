<?php

use App\PrepaidCard\Service\PrepaidCardService;
use App\PrepaidCard\Domain\Customer\Customer;
use App\PrepaidCard\Domain\Customer\CustomerRank\BlackRank;
use App\PrepaidCard\Domain\Customer\CustomerRank\GoldRank;
use App\PrepaidCard\Domain\Customer\CustomerRank\SilverRank;
use App\PrepaidCard\Domain\Money;
use App\PrepaidCard\Domain\PrepaidCard;
use App\PrepaidCard\Enum\ChargeAmount;
use App\PrepaidCard\Repository\CouponRepository;
use PHPUnit\Framework\TestCase;

class PrepaidCardTest extends TestCase{

    protected function setUp() :void {
        
    }

    /**
     * @test
     * @dataProvider 会員ランクとチャージ額に応じてボーナス金額が付与される用データ
     */
    public function 会員ランクとチャージ額に応じてボーナス金額が付与される(
        ChargeAmount $chargeAmount,
        Customer $customer,
        int $expectedBalance
    ) {
        $couponRepository = new CouponRepository();
        $prepaidCardService = new PrepaidCardService($couponRepository);
        $prepaidCard = new PrepaidCard(1, $customer, new Money(0));
        $probability = rand(1, 10);
        $prepaidCard = $prepaidCardService->charge($prepaidCard, $chargeAmount, $probability);

        $this->assertEquals($expectedBalance, $prepaidCard->getAmount());
    }

    public static function 会員ランクとチャージ額に応じてボーナス金額が付与される用データ() {
        $silverCustomer = new Customer(1,'silver', new SilverRank());
        $goldCustomer = new Customer(2,'gold', new GoldRank());
        $blackCustomer = new Customer(3,'black', new BlackRank());

        return [
            'シルバーランクで3000円チャージする' => [
                ChargeAmount::SMALL,
                $silverCustomer,
                3030,
            ],
            'シルバーランクで5000円チャージする' => [
                ChargeAmount::MEDIUM,
                $silverCustomer,
                5100,
            ],
            'シルバーランクで10000円チャージする' => [
                ChargeAmount::LARGE,
                $silverCustomer,
                10400,
            ],
            'ゴールドランクで3000円チャージする' => [
                ChargeAmount::SMALL,
                $goldCustomer,
                3090,
            ],
            'ゴールドランクで5000円チャージする' => [
                ChargeAmount::MEDIUM,
                $goldCustomer,
                5250,
            ],
            'ゴールドランクで10000円チャージする' => [
                ChargeAmount::LARGE,
                $goldCustomer,
                11000,
            ],
            'ブラックランクで3000円チャージする' => [
                ChargeAmount::SMALL,
                $blackCustomer,
                3150,
            ],
            'ブラックランクで5000円チャージする' => [
                ChargeAmount::MEDIUM,
                $blackCustomer,
                5350,
            ],
            'ブラックランクで10000円チャージする' => [
                ChargeAmount::LARGE,
                $blackCustomer,
                11500,
            ],
        ];
    }
}