<?php
namespace App\PizzaDelivery\Domain\Order;

use App\PizzaDelivery\Domain\Coupon\CouponInterface;
use App\PizzaDelivery\Domain\Order\Coupons;
use App\PizzaDelivery\Domain\Discounts\Discounts;
use App\PizzaDelivery\Domain\Money;
use App\PizzaDelivery\Enum\DeliveryType;

class Order {
    
    private ?int $id;

    private Money $price;

    private OrderDetails $orderDetails;

    private Discounts $discounts;

    private Coupons $coupons;

    private DeliveryType $deliveryType;

    public function __construct(
        ?int $id,
        Money $price,
        OrderDetails $orderDetails,
        Discounts $discounts,
        Coupons $coupons,
        DeliveryType $deliveryType,
    ) {
        $this->id = $id;
        $this->price = $price;
        $this->orderDetails = $orderDetails;
        $this->discounts = $discounts;
        $this->coupons = $coupons;
        $this->deliveryType = $deliveryType;
    }

    public function getId():?int {
        return $this->id;
    }

    public function getPrice():int {
        return $this->price->getValue();
    }

    // 割引・クーポン適用前の金額(表示用)
    public function getPriceBeforeDiscount():int {
        $discountSum = 0;
        foreach($this->discounts->asArray() as $discount) {
            $discountSum+=$discount->getPrice();
        }

        return $this->getPrice() + $discountSum;
    }

    public function getOrderDetails():OrderDetails {
        return $this->orderDetails;
    }

    public function getDiscounts(): Discounts {
        return $this->discounts;
    }

    public function getCoupons():Coupons {
        return $this->coupons;
    }

    public function getDeliveryType() {
        return $this->deliveryType;
    }

    public function getTotalPrice():int {
        return $this->orderDetails->getTotalPrice();
    }

    public function addOrderDetail(OrderDetail $orderDetail):void {
        $orderDetailsArray = $this->orderDetails->asArray();
        $orderDetailsArray[] = $orderDetail;
        $this->orderDetails = new OrderDetails($orderDetailsArray);
    }

    public function addCoupon(CouponInterface $coupon) {
        if ($this->coupons->hasCoupon($coupon)) {
            throw new \Exception('既に適応済みです');
        }
        $this->coupons = $this->coupons->addCoupon($coupon);
    }

    public function hasProductCategory(string $categoryCode): bool {
        foreach($this->orderDetails->asArray() as $orderDetail) {
            $orderDetailProduct = $orderDetail->getProduct();
            if ($orderDetailProduct->getCategory()->getCode() == $categoryCode) {
                return true;
            }
        }

        return false;
    }

    public function countProductCategory(string $categoryCode): int {
        $count = 0;
        foreach($this->orderDetails->asArray() as $orderDetail) {
            $orderDetailProduct = $orderDetail->getProduct();
            if ($orderDetailProduct->getCategory()->getCode() == $categoryCode) {
                $count++;
            }
        }

        return $count;
    }

    public function getMostExpensiveOrderDetailIndex(string $categoryCode):int {
        $mostExpensiveOrderDetailIndex = -1;
        $mostExpensivePrice = 0;
        foreach($this->orderDetails->asArray() as $index => $orderDetail) {
            $product = $orderDetail->getProduct();

            if($product->getCategory()->getCode() != $categoryCode) {
                continue;
            }

            if($orderDetail->getPrice() <= $mostExpensivePrice) {
                continue;
            }

            $mostExpensivePrice = $orderDetail->getPrice();
            $mostExpensiveOrderDetailIndex = $index;
        }

        if($mostExpensiveOrderDetailIndex == -1) {
            throw new \Exception('指定したカテゴリの商品は注文にありません');
        }

        return $mostExpensiveOrderDetailIndex;
    }

    public function beFreeOrderDetail(int $index):void {
        $this->orderDetails->beFree($index);
        $orderDetails = $this->orderDetails->asArray();
        $orderDetail = $orderDetails[$index];

        $this->price = new Money($this->getPrice() - $orderDetail->getProduct()->getPrice());
    }
}