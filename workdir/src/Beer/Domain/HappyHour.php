<?php
namespace App\Beer\Domain;

class HappyHour {

    private Time $startTime;

    private Time $endTime;

    public function __construct(
        Time $startTime,
        Time $endTime,
    ) {
        if ($startTime->getValue() >= $endTime->getValue())  {
            throw new \Exception('開始時刻は終了時刻よりも前の時刻を設定してください');
        }
        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }

    public function isWithinRange(\DateTimeImmutable $time): bool
    {
        return $time >= $this->startTime->getValue() && $time <= $this->endTime->getValue();
    }
}