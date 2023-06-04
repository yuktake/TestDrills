<?php

use App\GentlemanWear\Domain\Category;
use App\GentlemanWear\Domain\Money;
use App\GentlemanWear\Domain\Order\Order;
use App\GentlemanWear\Domain\Order\OrderDomainService;
use App\GentlemanWear\Domain\OrderDetail;
use App\GentlemanWear\Domain\OrderDetails;
use App\GentlemanWear\Domain\Product;
use App\GentlemanWear\Service\OrderService;
use PHPUnit\Framework\TestCase;

class GentlemanWearTest extends TestCase{

    protected function setUp() :void {
        
    }

    /**
     * @test
     * @dataProvider ワイシャツとネクタイをセットで購入すると「セット割引」で5％割引になる用データ
     */
    public function ワイシャツとネクタイをセットで購入すると「セット割引」で5％割引になる(
        int $expectedPrice,
        OrderDetails $orderDetails,
    ) {
        $orderDomainService = new OrderDomainService();
        $orderService = new OrderService($orderDomainService);

        $order = new Order(
            1,
            new Money($orderDetails->getTotalPrice()),
            $orderDetails,
            new \DateTimeImmutable(),
        );
        $order = $orderService->checkOrder($order);

        $this->assertEquals($expectedPrice, $order->getPrice());
    }

    /**
     * @test
     * @dataProvider ５月の最終週に７点以上購入すると「創業記念セール割引」で７％割引になる用データ
     */
    public function ５月の最終週に７点以上購入すると「創業記念セール割引」で７％割引になる(
        int $expectedPrice,
        OrderDetails $orderDetails,
        \DateTimeImmutable $orderAt,
    ) {
        $orderDomainService = new OrderDomainService();
        $orderService = new OrderService($orderDomainService);

        $order = new Order(
            1,
            new Money($orderDetails->getTotalPrice()),
            $orderDetails,
            $orderAt,
        );
        $order = $orderService->checkOrder($order);

        $this->assertEquals($expectedPrice, $order->getPrice());
    }

    /**
     * @test
     * @dataProvider セット割引と創業記念セール割引は併用可能用データ
     */
    public function セット割引と創業記念セール割引は併用可能(
        int $expectedPrice,
        OrderDetails $orderDetails,
        \DateTimeImmutable $orderAt,
    ) {
        $orderDomainService = new OrderDomainService();
        $orderService = new OrderService($orderDomainService);

        $order = new Order(
            1,
            new Money($orderDetails->getTotalPrice()),
            $orderDetails,
            $orderAt,
        );
        $order = $orderService->checkOrder($order);

        $this->assertEquals($expectedPrice, $order->getPrice());
    }

    public static function ワイシャツとネクタイをセットで購入すると「セット割引」で5％割引になる用データ() {
        $shirtCategory = new Category(1,'y-shirt','y-shirt');
        $tieCategory = new Category(2,'tie','tie');
        $shirt = new Product(1, 'shirt', $shirtCategory, new Money(2000));
        $tie = new Product(2, 'tie', $tieCategory, new Money(1000));
        $shirtOrderDetail = new OrderDetail(1, new Money($shirt->getPrice()), $shirt);
        $tieOrderDetail = new OrderDetail(2, new Money($tie->getPrice()), $tie);

        return [
            'ワイシャツとネクタイを購入' => [
                2850,
                new OrderDetails([$shirtOrderDetail, $tieOrderDetail]),
            ],
            'ワイシャツのみ購入' => [
                2000,
                new OrderDetails([$shirtOrderDetail]),
            ],
            'ネクタイのみ購入' => [
                1000,
                new OrderDetails([$tieOrderDetail]),
            ],
        ];
    }

    public static function ５月の最終週に７点以上購入すると「創業記念セール割引」で７％割引になる用データ() {
        $pantsCategory = new Category(3,'pants','pants');
        $pants = new Product(3, 'pants', $pantsCategory, new Money(5000));
        $pantsOrderDetail = new OrderDetail(3, new Money($pants->getPrice()), $pants);

        return [
            '5月の最終週に商品を７点以上購入' => [
                32550,
                new OrderDetails([
                    $pantsOrderDetail, 
                    $pantsOrderDetail, 
                    $pantsOrderDetail, 
                    $pantsOrderDetail, 
                    $pantsOrderDetail, 
                    $pantsOrderDetail, 
                    $pantsOrderDetail,
                ]),
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2023-05-31 00:00:00'),
            ],
            '5月の最終週に商品を６点購入' => [
                30000,
                new OrderDetails([
                    $pantsOrderDetail, 
                    $pantsOrderDetail, 
                    $pantsOrderDetail, 
                    $pantsOrderDetail, 
                    $pantsOrderDetail, 
                    $pantsOrderDetail, 
                ]),
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2023-05-31 00:00:00'),
            ],
            '5月の最終週以外に商品を７点以上購入' => [
                35000,
                new OrderDetails([
                    $pantsOrderDetail, 
                    $pantsOrderDetail, 
                    $pantsOrderDetail, 
                    $pantsOrderDetail, 
                    $pantsOrderDetail, 
                    $pantsOrderDetail, 
                    $pantsOrderDetail,
                ]),
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2023-05-01 00:00:00'),
            ],
            '5月の最終週以外に商品を６点購入' => [
                30000,
                new OrderDetails([
                    $pantsOrderDetail, 
                    $pantsOrderDetail, 
                    $pantsOrderDetail, 
                    $pantsOrderDetail, 
                    $pantsOrderDetail, 
                    $pantsOrderDetail, 
                ]),
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2023-05-01 00:00:00'),
            ],
        ];
    }

    public static function セット割引と創業記念セール割引は併用可能用データ() {
        $shirtCategory = new Category(1,'y-shirt','y-shirt');
        $tieCategory = new Category(2,'tie','tie');
        $shirt = new Product(1, 'shirt', $shirtCategory, new Money(2000));
        $tie = new Product(2, 'tie', $tieCategory, new Money(1000));
        $shirtOrderDetail = new OrderDetail(1, new Money($shirt->getPrice()), $shirt);
        $tieOrderDetail = new OrderDetail(2, new Money($tie->getPrice()), $tie);

        return [
            'セット割引と創業記念セール割引を併用' => [
                8800,
                new OrderDetails([
                    $shirtOrderDetail, 
                    $shirtOrderDetail, 
                    $shirtOrderDetail, 
                    $tieOrderDetail, 
                    $tieOrderDetail, 
                    $tieOrderDetail, 
                    $tieOrderDetail,
                ]),
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2023-05-31 00:00:00'),
            ]
        ];
    }
}