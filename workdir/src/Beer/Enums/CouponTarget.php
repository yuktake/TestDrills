<?php
namespace App\Beer\Enums;

enum CouponTarget: int
{
    case ALL_SITE_PRODUCT = 1;
    // Couponは特定のストアIDを知っている必要がある
    case ALL_STORE_PRODUCT = 2;
    // Couponは特定のブランドIDを知っている必要がある
    case BRAND = 3;
    // Couponは特定のプロダクトIDを知っている必要がある
    case PRODUCT_CODE = 4;
    case DELIVERY_FEE = 5;

    public static function fromValue(int $value): CouponTarget {
        return match($value) {
            1 => self::ALL_SITE_PRODUCT, 
            2 => self::ALL_STORE_PRODUCT,
            3 => self::BRAND,
            4 => self::PRODUCT_CODE,
            5 => self::DELIVERY_FEE,
        };
    }
}