<?php
namespace App\Beer\Domain;

use App\Beer\Domain\Coupon\CouponInterface;

class Order {

    private ?int $id;

    private Money $price;

    private Customer $customer;

    private OrderDetails $orderDetails;

    private Discounts $discounts;

    private Coupons $coupons;

    private DeliveryFee $deliveryFee;

    public function __construct(
        ?int $id,
        int $price,
        Customer $customer,
        OrderDetails $orderDetails,
        Discounts $discounts,
        Coupons $coupons,
        DeliveryFee $deliveryFee,
    ) {
        $this->id = $id;
        $this->price = new Money($price);
        $this->customer = $customer;
        $this->orderDetails = $orderDetails;
        $this->discounts = $discounts;
        $this->coupons = $coupons;
        $this->deliveryFee = $deliveryFee;
    }

    public function getId(): ?int {
        return $this->id;
    }

    // 割引後の金額
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

    public function getTotalPrice():int {
        return $this->price->getValue() + $this->getDeliveryFee()->getValue();
    }

    public function getCustomer():Customer {
        return $this->customer;
    }

    public function getOrderDetails(): OrderDetails {
        return $this->orderDetails;
    }

    public function getDiscounts(): Discounts {
        return $this->discounts;
    }

    public function getCoupons():Coupons {
        return $this->coupons;
    }

    public function getDeliveryFee():DeliveryFee {
        return $this->deliveryFee;
    }

    public function addCoupon(CouponInterface $coupon) {
        if ($this->coupons->hasCoupon($coupon)) {
            throw new \Exception('既に適応済みです');
        }
        $this->coupons = $this->coupons->addCoupon($coupon);
    }

    public function addOrderDetail(OrderDetail $orderDetail) {
        $this->orderDetails->addOrderDetail($orderDetail);
    }

    public function hasProduct(Product $product):bool {
        return $this->orderDetails->hasProduct($product);
    }
}