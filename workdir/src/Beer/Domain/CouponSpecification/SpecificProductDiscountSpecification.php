<?php
namespace App\Beer\Domain\CouponSpecification;

use App\Beer\Domain\Discount;
use App\Beer\Domain\Money;
use App\Beer\Domain\Order;
use App\Beer\Domain\OrderDetail;
use App\Beer\Domain\OrderDetails;
use App\Beer\Domain\Product;

class SpecificProductDiscountSpecification implements CouponSpecificationInterface {

    private Product $product;

    private int $appliedPrice;

    public function __construct(
        Product $product,
        int $appliedPrice,
    ) {
        $this->product = $product;
        if($product->getPrice() <= $appliedPrice) {
            throw new \Exception('applied price is not discounted');
        }
        $this->appliedPrice = $appliedPrice;
    }

    public function apply(Order $order): Order
    {
        $appliedOrderDetails = [];
        foreach($order->getOrderDetails()->asArray() as $orderDetail) {
            $product = $orderDetail->getProduct();
            if ($orderDetail->getProduct()->getProductCode() == $this->product->getProductCode()) {
                $discounts = $orderDetail->getDiscounts();
                $discount = new Discount(
                    null, 
                    new Money($this->getDiscountedPrice()), 
                    $this->product->getName().' is discounted'
                );
                $discounts->add($discount);
                $appliedOrderDetail = new OrderDetail(
                    $orderDetail->getId(),
                    $this->appliedPrice,
                    $discounts,
                    $product,
                );
                $appliedOrderDetails[] = $appliedOrderDetail;
            } else {
                $appliedOrderDetails[] = $orderDetail;
            }
        }
        $orderDetails = new OrderDetails($appliedOrderDetails);

        $discounts = $order->getDiscounts();
        $discount = new Discount(
            null, 
            new Money($this->getDiscountedPrice()), 
            $this->product->getName().' is discounted'
        );
        $discounts->add($discount);
        $appliedOrder = new Order(
            $order->getId(),
            $orderDetails->getTotalPrice(),
            $order->getCustomer(),
            $orderDetails,
            $discounts,
            $order->getCoupons(),
            $order->getDeliveryFee(),
        );
        // var_dump('SpecificProductDiscountSpecification');
        // var_dump($appliedOrder->getPrice());

        return $appliedOrder;
    }

    private function getDiscountedPrice():int {
        return $this->product->getPrice() - $this->appliedPrice;
    }
}