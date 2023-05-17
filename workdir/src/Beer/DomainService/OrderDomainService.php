<?php
namespace App\Beer\DomainService;

use App\Beer\Domain\Coupons;
use App\Beer\Domain\Order;
use App\Beer\Domain\Coupon\CouponInterface;

class OrderDomainService {

    public function __construct(
        
    ) {
        
    }

    public function couponIsApplicable(Order $order, CouponInterface $coupon):bool {
        if (!$coupon->isAvailable()) {
            return false;
        }

        // Couponの使用回数が決まっている場合
        if (!is_null($coupon->getUseLimit())) {
            
        }

        // ユーザごとにCouponの使用回数が決まっている場合
        if (!is_null($coupon->getUseLimitByCustomer())) {
            
        }
    
        return $coupon->isApplicable($order);
    }

    public function applyCoupon(Order $order, CouponInterface $coupon): Order {
        $order->addCoupon($coupon);

        $appliedOrder = $this->calculateCouponsOrder($order);

        return $appliedOrder;
    }

    private function calculateCouponsOrder(Order $order):Order {
        $orders = [];
        $coupons = $order->getCoupons()->asArray();

        $combinations = $this->permutation($coupons, count($coupons));
        // クーポンの適用順で最も最小金額になる組み合わせを探す
        foreach ($combinations as $coupons) {
            $couponCollection = new Coupons($coupons);
            $appliedOrder = $couponCollection->apply($order);
            $orders[] = $appliedOrder;
        }
        // 最小注文金額のOrderを返す
        $minTotalPriceOrder = $this->getMinTotalPriceOrder($orders);

        return $minTotalPriceOrder;
    }

    private function getMinTotalPriceOrder(Array $orders):Order {
        $totalPrices = [];
        foreach($orders as $order) {
            $totalPrices[] = $order->getTotalPrice();
        }

        $minTotalPriceIndex = array_keys($totalPrices, min($totalPrices))[0];

        return $orders[$minTotalPriceIndex];
    }

    // クーポンの順列を返す
    private function permutation(array $arr, int $r): ?array {
        $n = count($arr);
        $result = []; // 最終的に二次元配列にして返す

        // nPr の条件に一致していなければ null を返す
        if($n < 1 || $n < $r){ return null; }

        if($r === 1){
            foreach($arr as $item){
                $result[] = [$item];
            }
        }

        if($r > 1){
            // $item が先頭になる順列を算出する
            foreach($arr as $key => $item){
                // $item を除いた配列を作成
                $newArr = array_filter($arr, function($k) use($key) {
                    return $k !== $key;
                }, ARRAY_FILTER_USE_KEY);
                // 再帰処理 二次元配列が返ってくる
                $recursion = self::permutation($newArr, $r - 1);
                foreach($recursion as $one_set){
                    array_unshift($one_set, $item);
                    $result[] = $one_set;
                }
            }
        }

        return $result;
    }
}