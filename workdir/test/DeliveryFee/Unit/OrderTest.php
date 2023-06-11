<?php
namespace Test\DeliveryFee\Unit;

use App\DeliveryFee\Domain\Customer;
use App\DeliveryFee\Domain\Money;
use App\DeliveryFee\Domain\Order\DeliveryType;
use App\DeliveryFee\Enum\DeliveryType as DeliveryTypeEnum;
use App\DeliveryFee\Domain\Order\Order;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase{

    protected function setUp() :void {
        
    }

    /**
     * @test
     * @dataProvider 注文の合計金額が５０００円以上だと通常配送料が無料になる用データ
     */
    public function 注文の合計金額が５０００円以上だと通常配送料が無料になる(
        Order $order,
        int $expectedDeliveryFee,
    ) {
        $this->assertEquals($expectedDeliveryFee, $order->getDeliveryFee());
    }

    /**
     * @test
     * @dataProvider お急ぎ便を利用すると追加で500円かかる用データ
     */
    public function お急ぎ便を利用すると追加で500円かかる(
        Order $order,
        int $expectedDeliveryFee,
    ) {
        $this->assertEquals($expectedDeliveryFee, $order->getDeliveryFee());
    }

    /**
     * @test
     * @dataProvider プレミアム会員は通常配送料が無料になる用データ
     */
    public function プレミアム会員は通常配送料が無料になる(
        Order $order,
        int $expectedDeliveryFee,
    ) {
        $this->assertEquals($expectedDeliveryFee, $order->getDeliveryFee());
    }

    public static function 注文の合計金額が５０００円以上だと通常配送料が無料になる用データ() {
        $customer = new Customer(null,'bob',false,);

        return [
            '5000円以上購入' => [
                new Order(
                    null,
                    $customer,
                    new Money(5000),
                    new DeliveryType(DeliveryTypeEnum::NORMAL),
                ),
                0,
            ],
            '5000円未満購入' => [
                new Order(
                    null,
                    $customer,
                    new Money(1000),
                    new DeliveryType(DeliveryTypeEnum::NORMAL),
                ),
                500,
            ],
        ];
    }

    public static function お急ぎ便を利用すると追加で500円かかる用データ() {
        $customer = new Customer(null,'bob',false,);

        return [
            'お急ぎ便を利用する' => [
                new Order(
                    null,
                    $customer,
                    new Money(1000),
                    new DeliveryType(DeliveryTypeEnum::EXPRESS),
                ),
                1000,
            ],
            'お急ぎ便を利用しない' => [
                new Order(
                    null,
                    $customer,
                    new Money(1000),
                    new DeliveryType(DeliveryTypeEnum::NORMAL),
                ),
                500,
            ],
        ];
    }

    public static function プレミアム会員は通常配送料が無料になる用データ() {
        $normalCustomer = new Customer(null,'bob',false,);
        $premiumCustomer = new Customer(null,'bob',true,);

        return [
            'プレミアム会員' => [
                new Order(
                    null,
                    $premiumCustomer,
                    new Money(1000),
                    new DeliveryType(DeliveryTypeEnum::NORMAL),
                ),
                0,
            ],
            'プレミアム会員ではない' => [
                new Order(
                    null,
                    $normalCustomer,
                    new Money(1000),
                    new DeliveryType(DeliveryTypeEnum::NORMAL),
                ),
                500,
            ],
        ];
    }
}