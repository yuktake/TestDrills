<?php
namespace App\Beer\Domain\CouponCondition;

use App\Beer\Domain\Order;

class SpecificProductExistCondition implements CouponConditionInterface {

    private String $productCode;

    public function __construct(
        String $productCode,
    ) {
        $this->productCode = $productCode;
    }

    public function appliable(Order $order): bool
    {
        foreach($order->getOrderDetails()->asArray() as $orderDetail) {
            $product = $orderDetail->getProduct();
            if ($product->getProductCode() == $this->productCode) {
                return true;
            }
        }

        return false;
    }
}