<?php

use App\PizzaDelivery\Domain\Coupon\CouponSpecification\DiscountOrderPriceByRatioSpecification;
use App\PizzaDelivery\Domain\Coupon\AvailablePeriod;
use App\PizzaDelivery\Domain\Coupon\Coupon;
use App\PizzaDelivery\Domain\Coupon\CouponConditions;
use App\PizzaDelivery\Domain\Coupon\CouponInterface;
use App\PizzaDelivery\Domain\Coupon\CouponSpecifications;
use App\PizzaDelivery\Domain\Discounts\Discounts;
use App\PizzaDelivery\Domain\Money;
use App\PizzaDelivery\Domain\Order\Coupons;
use App\PizzaDelivery\Domain\Order\Order;
use App\PizzaDelivery\Domain\Order\OrderDetail;
use App\PizzaDelivery\Domain\Order\OrderDetails;
use App\PizzaDelivery\Domain\Order\OrderDomainService;
use App\PizzaDelivery\Domain\Product\Product;
use App\PizzaDelivery\Domain\Product\Category;
use App\PizzaDelivery\Enum\DeliveryType;
use App\PizzaDelivery\Service\OrderService;
use PHPUnit\Framework\TestCase;

class OrderServiceTest extends TestCase{

    protected function setUp() :void {
        
    }

    /**
     * @test
     * @group 注文が１５００円以上の場合フライドポテトを無料でサービスする
     * @dataProvider 個数の確認用データ
     */
    public function 個数の確認(
        int $expectedNumber,
        OrderDetails $orderDetails,
    ) {
        $orderDomainService = new OrderDomainService();
        $orderService = new OrderService($orderDomainService);

        $order = new Order(
            null, 
            new Money($orderDetails->getTotalPrice()), 
            $orderDetails, 
            new Discounts([]),
            new Coupons([]),
            DeliveryType::DELIVERY
        );
        $order = $orderService->confirmOrder($order);

        $this->assertEquals($expectedNumber, count($order->getOrderDetails()->asArray()));
    }

    /**
     * @test
     * @group 注文が１５００円以上の場合フライドポテトを無料でサービスする
     * @dataProvider 金額の確認用データ
     */
    public function 金額の確認(
        int $expectedPrice,
        OrderDetails $orderDetails,
    ) {
        $orderDomainService = new OrderDomainService();
        $orderService = new OrderService($orderDomainService);

        $order = new Order(
            null, 
            new Money($orderDetails->getTotalPrice()), 
            $orderDetails, 
            new Discounts([]),
            new Coupons([]),
            DeliveryType::DELIVERY
        );
        $order = $orderService->confirmOrder($order);

        $this->assertEquals($expectedPrice, $order->getPrice());
    }

    /**
     * @test
     * @dataProvider 店頭受け取りの場合、２枚目のピザが無料になる用データ
     */
    public function 店頭受け取りの場合、２枚目のピザが無料になる(
        int $expectedPrice,
        OrderDetails $orderDetails,
    ) {
        $orderDomainService = new OrderDomainService();
        $orderService = new OrderService($orderDomainService);

        $order = new Order(
            null, 
            new Money($orderDetails->getTotalPrice()), 
            $orderDetails, 
            new Discounts([]),
            new Coupons([]),
            DeliveryType::PICKUP
        );
        $order = $orderService->confirmOrder($order);

        $this->assertEquals($expectedPrice, $order->getPrice());
    }
    
    /**
     * @test
     * @dataProvider 宅配の場合、クーポンを使用すれば２割引になる用データ
     */
    public function 宅配の場合、クーポンを使用すれば２割引になる(
        int $expectedPrice,
        OrderDetails $orderDetails,
        bool $useCoupon,
    ) {
        $orderDomainService = new OrderDomainService();
        $orderService = new OrderService($orderDomainService);

        $order = new Order(
            null, 
            new Money($orderDetails->getTotalPrice()), 
            $orderDetails, 
            new Discounts([]),
            new Coupons([]),
            DeliveryType::DELIVERY
        );
        $order = $orderService->confirmOrder($order);

        if ($useCoupon) {
            $coupon = $this->createCoupon();
            $order = $orderService->applyCoupon($order, $coupon);
        }

        $this->assertEquals($expectedPrice, $order->getPrice());
    }

    // TODO:: couponIsApplicableのテスト

    private function createCoupon():CouponInterface {
        $couponConditions = new CouponConditions([]);
        $discountRatioSpecification = new DiscountOrderPriceByRatioSpecification(0.2);
        $couponSpecifications = new CouponSpecifications([$discountRatioSpecification]);

        $coupon = new Coupon(
            1,
            'beer',
            $couponConditions,
            $couponSpecifications,
            null,
            null,
            new AvailablePeriod(
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2000-01-01 00:00:00'),
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2100-01-31 23:59:59'),
            )
        );

        return $coupon;
    }

    public static function 個数の確認用データ() {
        $pizzaCategory = new Category(1, 'pizza', 'pizza');
        $pizzaS = new Product(1, 'pizza', $pizzaCategory, new Money(1000), 'pizza-s');
        $pizzaM = new Product(2, 'pizza', $pizzaCategory, new Money(2000), 'pizza-m');
        $pizzaSOrderDetail = new OrderDetail(1, new Money($pizzaS->getPrice()), new Discounts([]), $pizzaS);
        $pizzaMOrderDetail = new OrderDetail(2, new Money($pizzaM->getPrice()), new Discounts([]), $pizzaM);

        return [
            '1500円以上' => [
                2,
                new OrderDetails([$pizzaMOrderDetail]),
            ],
            '1500円未満' => [
                1,
                new OrderDetails([$pizzaSOrderDetail]),
            ]
        ];
    }

    public static function 金額の確認用データ() {
        $pizzaCategory = new Category(1, 'pizza', 'pizza');
        $pizzaS = new Product(1, 'pizza', $pizzaCategory, new Money(1000), 'pizza-s');
        $pizzaM = new Product(2, 'pizza', $pizzaCategory, new Money(2000), 'pizza-m');
        $pizzaSOrderDetail = new OrderDetail(1, new Money($pizzaS->getPrice()), new Discounts([]), $pizzaS);
        $pizzaMOrderDetail = new OrderDetail(2, new Money($pizzaM->getPrice()), new Discounts([]), $pizzaM);

        return [
            '1500円以上' => [
                2000,
                new OrderDetails([$pizzaMOrderDetail]),
            ],
            '1500円未満' => [
                1000,
                new OrderDetails([$pizzaSOrderDetail]),
            ]
        ];
    }

    public static function 店頭受け取りの場合、２枚目のピザが無料になる用データ() {
        $pizzaCategory = new Category(1, 'pizza', 'pizza');
        $pizza = new Product(1, 'pizza', $pizzaCategory, new Money(2000), 'pizza-m');
        $pizzaOrderDetail1 = new OrderDetail(1, new Money($pizza->getPrice()), new Discounts([]), $pizza);
        $pizzaOrderDetail2 = new OrderDetail(2, new Money($pizza->getPrice()), new Discounts([]), $pizza);
        $pizzaOrderDetail3 = new OrderDetail(3, new Money($pizza->getPrice()), new Discounts([]), $pizza);
        $pizzaOrderDetail4 = new OrderDetail(4, new Money($pizza->getPrice()), new Discounts([]), $pizza);
        $pizzaOrderDetail5 = new OrderDetail(5, new Money($pizza->getPrice()), new Discounts([]), $pizza);

        return [
            'ピザ2枚' => [
                2000,
                new OrderDetails([$pizzaOrderDetail1, $pizzaOrderDetail2]),
            ],
            'ピザ3枚' => [
                4000,
                new OrderDetails([$pizzaOrderDetail3, $pizzaOrderDetail4, $pizzaOrderDetail5]),
            ]
        ];
    }

    public static function 宅配の場合、クーポンを使用すれば２割引になる用データ() {
        $pizzaCategory = new Category(1, 'pizza', 'pizza');
        $pizza = new Product(1, 'pizza', $pizzaCategory, new Money(2000), 'pizza-m');
        $pizzaOrderDetail1 = new OrderDetail(1, new Money($pizza->getPrice()), new Discounts([]), $pizza);
        $pizzaOrderDetail2 = new OrderDetail(2, new Money($pizza->getPrice()), new Discounts([]), $pizza);

        return [
            'クーポンを使う' => [
                3200,
                new OrderDetails([$pizzaOrderDetail1, $pizzaOrderDetail2]),
                true,
            ],
            'クーポン使わない' => [
                4000,
                new OrderDetails([$pizzaOrderDetail1, $pizzaOrderDetail2]),
                false,
            ]
        ];
    }
}