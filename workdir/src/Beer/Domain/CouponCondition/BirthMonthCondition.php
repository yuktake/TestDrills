<?php
namespace App\Beer\Domain\CouponCondition;

use App\Beer\Domain\MonthEnd;
use App\Beer\Domain\MonthStart;
use App\Beer\Domain\Order;

class BirthMonthCondition implements CouponConditionInterface {

    private MonthStart $birthMonthStart;

    private MonthEnd $birthMonthEnd;

    public function __construct(
        MonthStart $birthMonthStart,
        MonthEnd $birthMonthEnd,
    ) {
        if ($birthMonthStart->getValue() >= $birthMonthEnd->getValue())  {
            throw new \Exception('MonthStartはMonthEndよりも前の時刻を設定してください');
        }
        $this->birthMonthStart = $birthMonthStart;
        $this->birthMonthEnd = $birthMonthEnd;
    }

    public function appliable(Order $order): bool
    {
        $birthDay = $order->getCustomer()->getBirthday();
        
        return $birthDay >= $this->birthMonthStart->getValue() && $birthDay <= $this->birthMonthEnd->getValue();
    }
}