<?php

use App\Beer\Domain\Coupon\AvailablePeriod;
use App\Beer\Domain\Coupon\CouponConditions;
use App\Beer\Domain\Coupons;
use App\Beer\Domain\Customer;
use App\Beer\Domain\DeliveryFee;
use App\Beer\DomainService\OrderDomainService;
use App\Beer\Domain\Coupon\CouponInterface;
use App\Beer\Domain\Coupon\CouponSpecifications;
use App\Beer\Domain\Order;
use App\Beer\Domain\OrderDetail;
use App\Beer\Domain\OrderDetails;
use App\Beer\Domain\Product;
use App\Beer\Domain\Coupon\Coupon;
use App\Beer\Domain\CouponCondition\SpecificProductExistCondition;
use App\Beer\Domain\CouponSpecification\SpecificProductDiscountSpecification;
use App\Beer\DomainService\OrderDetailDomainService;
use PHPUnit\Framework\TestCase;

class BeerTest extends TestCase{

    protected function setUp() :void {
        
    }

    /**
     * @test
     * @dataProvider クーポンを使うまたはハッピーアワーだと割引になる用データ
     */
    public function クーポンを使うまたはハッピーアワーだと割引になる(
        \DateTimeImmutable $orderAt,
        bool $useCoupon,
        int $expectedPrice,
    ) {
        $orderDomainService = new OrderDomainService();
        $orderDetailDomainService = new OrderDetailDomainService();

        $beer = new Product('Beer',490,'beer-S',290);
        $happyHourPrice = $orderDetailDomainService->getHappyHourPrice($beer, $orderAt);
        $orderDetail = new OrderDetail(null,$happyHourPrice,$beer);
        $orderDetails = new OrderDetails([$orderDetail]);
        $customer = new Customer('Bob',new \DateTimeImmutable());

        $order = new Order(
            null,
            $orderDetails->getTotalPrice(),
            $customer,
            $orderDetails,
            new Coupons([]),
            new DeliveryFee(0),
        );

        if ($useCoupon) {
            $beerCoupon = $this->createBeerCoupon();
            if (!$orderDomainService->couponIsApplicable($order, $beerCoupon)) {
                throw new \Exception('Error');
            }

            $order = $orderDomainService->applyCoupon($order, $beerCoupon);
        }

        $this->assertEquals($expectedPrice, $order->getTotalPrice());
    }

    private function createBeerCoupon():CouponInterface {
        $beerCondition = new SpecificProductExistCondition("beer-S");
        $couponConditions = new CouponConditions([$beerCondition]);

        $beerSpecification = new SpecificProductDiscountSpecification('beer-S', 100);
        $couponSpecifications = new CouponSpecifications([$beerSpecification]);

        $beerCoupon = new Coupon(
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

        return $beerCoupon;
    }

    public static function クーポンを使うまたはハッピーアワーだと割引になる用データ() {
        return [
            'ハッピーアワーではなくクーポンは使わない' => [
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', date('Y-m-d').' 20:00:00'),
                false,
                490
            ],
            'ハッピーアワーではなくクーポンを使用する' => [
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', date('Y-m-d').' 20:00:00'),
                true,
                100
            ],
            'ハッピーアワーかつクーポンは使わない' => [
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', date('Y-m-d').' 17:00:00'),
                false,
                290
            ],
            'ハッピーアワーかつクーポンを使用する' => [
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', date('Y-m-d').' 17:00:00'),
                true,
                100
            ],
        ];
    }
}