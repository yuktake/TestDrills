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
use App\Beer\Domain\CouponSpecification\TotalPriceDiscountRatioSpecification;
use App\Beer\Domain\CouponSpecification\TotalPriceDiscountSpecification;
use App\Beer\Domain\Discounts;
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
        $orderDetail = new OrderDetail(null, $happyHourPrice, new Discounts([]), $beer);
        $orderDetails = new OrderDetails([$orderDetail]);
        $customer = new Customer('Bob',new \DateTimeImmutable());

        $order = new Order(
            null,
            $orderDetails->getTotalPrice(),
            $customer,
            $orderDetails,
            new Discounts([]),
            new Coupons([]),
            new DeliveryFee(0),
        );

        if ($useCoupon) {
            $beerCoupon = $this->createBeerCoupon();
            $totalPriceAmountDiscountCoupon = $this->createTotalPriceAmountDiscountCoupon();
            $totalPriceRatioDiscountCoupon = $this->createTotalPriceRatioDiscountCoupon();
            if (!$orderDomainService->couponIsApplicable($order, $beerCoupon)) {
                throw new \Exception('Error');
            }
            if (!$orderDomainService->couponIsApplicable($order, $totalPriceAmountDiscountCoupon)) {
                throw new \Exception('Error2');
            }
            if (!$orderDomainService->couponIsApplicable($order, $totalPriceRatioDiscountCoupon)) {
                throw new \Exception('Error3');
            }

            $order = $orderDomainService->applyCoupon($order, $beerCoupon);
            $order = $orderDomainService->applyCoupon($order, $totalPriceAmountDiscountCoupon);
            $order = $orderDomainService->applyCoupon($order, $totalPriceRatioDiscountCoupon);
        }

        $this->assertEquals($expectedPrice, $order->getTotalPrice());
    }

    private function createBeerCoupon():CouponInterface {
        $beerCondition = new SpecificProductExistCondition("beer-S");
        $couponConditions = new CouponConditions([$beerCondition]);

        $beer = new Product('Beer',490,'beer-S',290);
        $beerSpecification = new SpecificProductDiscountSpecification($beer, 100);

        $beerCoupon = new Coupon(
            1,
            'beer',
            $couponConditions,
            new CouponSpecifications([$beerSpecification]),
            null,
            null,
            new AvailablePeriod(
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2000-01-01 00:00:00'),
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2100-01-31 23:59:59'),
            )
        );

        return $beerCoupon;
    }

    private function createTotalPriceAmountDiscountCoupon():CouponInterface {
        $beerCondition = new SpecificProductExistCondition("beer-S");
        $couponConditions = new CouponConditions([$beerCondition]);
        $totalPriceSpecification = new TotalPriceDiscountSpecification(50);

        $totalPriceAmountDiscountCoupon = new Coupon(
            1,
            'totalPriceDiscount',
            $couponConditions,
            new CouponSpecifications([$totalPriceSpecification]),
            null,
            null,
            new AvailablePeriod(
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2000-01-01 00:00:00'),
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2100-01-31 23:59:59'),
            )
        );

        return $totalPriceAmountDiscountCoupon;
    }

    private function createTotalPriceRatioDiscountCoupon():CouponInterface {
        $beerCondition = new SpecificProductExistCondition("beer-S");
        $couponConditions = new CouponConditions([$beerCondition]);
        $totalPriceRatioSpecification = new TotalPriceDiscountRatioSpecification(0.9);

        $totalPriceRatioDiscountCoupon = new Coupon(
            1,
            'totalPriceRatio',
            $couponConditions,
            new CouponSpecifications([$totalPriceRatioSpecification]),
            null,
            null,
            new AvailablePeriod(
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2000-01-01 00:00:00'),
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2100-01-31 23:59:59'),
            )
        );

        return $totalPriceRatioDiscountCoupon;
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
                0
            ],
            'ハッピーアワーかつクーポンは使わない' => [
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', date('Y-m-d').' 17:00:00'),
                false,
                290
            ],
            'ハッピーアワーかつクーポンを使用する' => [
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', date('Y-m-d').' 17:00:00'),
                true,
                0
            ],
        ];
    }
}