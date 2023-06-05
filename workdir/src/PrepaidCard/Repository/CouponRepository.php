<?php
namespace App\PrepaidCard\Repository;

use App\PrepaidCard\Domain\Customer\Customer;

class CouponRepository {

    public function issue(Customer $customer):void {
        echo 'Coupon is issued';
    }
}