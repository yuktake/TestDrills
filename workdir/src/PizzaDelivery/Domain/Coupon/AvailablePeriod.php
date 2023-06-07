<?php
namespace App\PizzaDelivery\Domain\Coupon;

class AvailablePeriod {

    private \DateTimeImmutable $start;

    private \DateTimeImmutable $end;

    public function __construct(
        \DateTimeImmutable $start,
        \DateTimeImmutable $end,
    ) {
        if ($start >= $end)  {
            throw new \Exception('開始時刻は終了時刻よりも前の時刻を設定してください');
        }
        $this->start = $start;
        $this->end = $end;
    }

    public function isAvailable(\DateTimeImmutable $time): bool
    {
        return $time >= $this->start && $time <= $this->end;
    }
}