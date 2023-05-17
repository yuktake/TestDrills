<?php
namespace App\Beer\Domain\CouponSpecification;

use App\Beer\Domain\Order;

interface CouponSpecificationInterface {

    public function apply(Order $order): Order;
}